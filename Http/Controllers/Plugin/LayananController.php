<?php

namespace Modules\PPID\Http\Controllers\Plugin;

use Modules\Core\Http\Controllers\CoreController as Controller;
use Illuminate\Http\Request;

use Modules\PPID\Entities\Plugin\Layanan;

class LayananController extends Controller
{
    protected $title = 'Produk & Layanan';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Layanan $data
     */
    public function __construct(Layanan $data) 
    {
        $this->data = $data;

        $this->toIndex = route('epanel.layanan.index');
        $this->prefix = 'epanel.layanan';
        $this->view = 'ppid::plugin.layanan';

        $this->tCreate = __('core::general.created', ['attribute' => strtolower($this->title)]);
        $this->tUpdate = __('core::general.updated', ['attribute' => strtolower($this->title)]);
        $this->tDelete = __('core::general.deleted', ['attribute' => strtolower($this->title)]);

        view()->share([
            'title' => $this->title, 
            'view' => $this->view, 
            'prefix' => $this->prefix
        ]);
    }

    /**
     * Tampilkan halaman utama modul yang dipilih
     * 
     * @param Request $request
     * @return Response|View
     */
    public function index(Request $request) 
    {
        $data = $this->data->latest()->get();

        if($request->has('datatable')):
            return $this->datatable($data);
        endif;

        return view("$this->view.index", compact('data'));
    }

    /**
     * Tampilkan halaman untuk menambah data
     * 
     * @return Response|View
     */
    public function create() 
    {
        return view("$this->view.create");
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param Request $request
     * @return Response|View
     */
    public function store(Request $request) 
    {
        $this->validate(request(), [
            'nama' => 'required', 
            'pd' => 'required', 
            'alamat' => 'required', 
            'narahubung_nama' => 'required', 
            'narahubung_jabatan' => 'required', 
            'narahubung_telepon' => 'required'
        ]);

        $input = request()->all();
        $this->data->create($input);

        notify()->flash($this->tCreate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Menampilkan detail lengkap
     * 
     * @param Int $id
     * @return Response|View
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Tampilkan halaman perubahan data
     * 
     * @param Int $id
     * @return Response|View
     */
    public function edit($id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();
    
        return view("$this->view.edit", compact('edit'));
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param Request $request
     * @param Int $id
     * @return Response|View
     */
    public function update(Request $request, $id)
    {
        $edit = $this->data->uuid($id)->firstOrFail();

        $this->validate(request(), [
            'nama' => 'required', 
            'pd' => 'required', 
            'alamat' => 'required', 
            'narahubung_nama' => 'required', 
            'narahubung_jabatan' => 'required', 
            'narahubung_telepon' => 'required'
        ]);

        $input = $request->all();
        $edit->update($input);

        notify()->flash($this->tUpdate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Lakukan penghapusan data yang tidak diinginkan
     * 
     * @param Request $request
     * @param Int $id
     * @return Response|String
     */
    public function destroy(Request $request, $id)
    {
        if($request->has('pilihan')):
            foreach($request->pilihan as $temp):
                $each = $this->data->uuid($temp)->firstOrFail();

                // $unduhan = $this->unduhan->whereIdKategori($each->id)->first();
                // hapusFile(str_replace('storage/', '', $unduhan->file));
                // $unduhan->delete();

                $each->delete();
            endforeach;
            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
    }

    /**
     * Datatable API
     * 
     * @param  $data
     * @return Datatable
     */
    public function datatable($data) 
    {
        return datatables()->of($data)
            ->editColumn('pilihan', function($data) {
                $return  = '<span>';
                $return .= '    <div class="checkbox checkbox-only">';
                $return .= '        <input type="checkbox" id="pilihan['.$data->id.']" name="pilihan[]" value="'.$data->uuid.'">';
                $return .= '        <label for="pilihan['.$data->id.']"></label>';
                $return .= '    </div>';
                $return .= '</span>';
                return $return;
            })
            ->editColumn('nama', function($data) {
                $return = $data->nama;
                $return .= '<div class="font-11 color-blue-grey-lighter">';
                $return .= '    Bidang: <b>' . optional($data->rel_bidang)->label . '</b>';
                $return .= '</div>';
                return $return;
            })
            ->editColumn('narahubung_nama', function($data) {
                $return  = '<div class="font-11 color-blue-grey-lighter uppercase">Nama</div>';
                $return .= $data->narahubung_nama;
                return $return;
            })
            ->editColumn('narahubung_telepon', function($data) {
                $return  = '<div class="font-11 color-blue-grey-lighter uppercase">Telepon</div>';
                $return .= $data->narahubung_telepon;
                return $return;
            })
            ->editColumn('narahubung_jabatan', function($data) {
                $return  = '<div class="font-11 color-blue-grey-lighter uppercase">Jabatan</div>';
                $return .= $data->narahubung_jabatan;
                return $return;
            })
            ->editColumn('aksi', function($data) {
                $return  = '<div class="btn-toolbar">';
                $return .= '    <div class="btn-group btn-group-sm">';
                $return .= '        <a href="'. route("$this->prefix.edit", $data->uuid) .'" role="button" class="btn btn-sm btn-primary-outline">';
                $return .= '            <span class="fa fa-pencil"></span>';
                $return .= '        </a>';
                $return .= '    </div>';
                $return .= '</div>';
                return $return;
            })
            ->rawColumns(['pilihan', 'nama', 'narahubung_nama', 'narahubung_telepon', 'narahubung_jabatan', 'aksi'])->make(true);
    }
}
