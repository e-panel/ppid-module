<?php

namespace Modules\PPID\Http\Controllers\Plugin;

use Modules\Core\Http\Controllers\CoreController as Controller;
use Illuminate\Http\Request;

use Modules\PPID\Entities\Plugin\Pengadaan;

class PengadaanController extends Controller
{
    protected $title = 'Pengadaan Barang dan Jasa';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Model
     */
    public function __construct(Pengadaan $data) 
    {
        $this->data = $data;

        $this->toIndex = route('epanel.pengadaan.index');
        $this->prefix = 'epanel.pengadaan';
        $this->view = 'ppid::plugin.pengadaan';

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
     * @param Illuminate\Http\Request
     * @return Illuminate\View\View
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
     * @return Illuminate\View\View
     */
    public function create() 
    {
        # Tampilkan View
        return view("$this->view.create");
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param  Illuminate\Http\Request
     * @return mixed
     */
    public function store(Request $request) 
    {
        $this->validate($request, [
            'nama_paket' => 'required',
            'nama_kegiatan' => 'required',
            'volume' => 'required',
        ]);

        $input = $request->all();
        
        $input['id_operator'] = auth()->user()->id;
        $input['pagu'] = $request->filled('pagu') ? str_replace(".", "", $request->pagu) : 0;

        $this->data->create($input);

        notify()->flash($this->tCreate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Menampilkan detail lengkap
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Illuminate\View\View
     */
    public function show($id) 
    {
        return abort(404);
    }

    /**
     * Tampilkan halaman perubahan data
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Illuminate\View\View
     */
    public function edit($id) 
    {
        # Select specify data by id
        $edit = $this->data->uuid($id)->firstOrFail();
        
        # Tampilkan View
        return view("$this->view.edit", compact('edit'));
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Back [Tampilkan halaman yang sama]
     */
    public function update(Request $request, $id) 
    {
        $edit = $this->data->uuid($id)->firstOrFail();
        
        $this->validate($request, [
            'nama_paket' => 'required',
            'nama_kegiatan' => 'required',
            'volume' => 'required',
        ]);

        $input = $request->all();
        $input['pagu'] = $request->filled('pagu') ? str_replace(".", "", $request->pagu) : 0;

        $edit->update($input);

        notify()->flash($this->tUpdate, 'success');
        return redirect($this->toIndex);
    }

    /**
     * Lakukan penghapusan data yang tidak diinginkan
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return String
     */
    public function destroy(Request $request, $id) 
    {
        if($request->has('pilihan')):
            foreach($request->pilihan as $temp):
                $each = $this->data->uuid($temp)->firstOrFail();
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
    protected function datatable($data) 
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
            ->editColumn('paket', function($data) {
                $return  = $data->nama_paket;
                return $return;
            })
            ->editColumn('pagu', function($data) {
                $return  = rupiah($data->pagu);
                return $return;
            })
            ->editColumn('jenis', function($data) {
                $return  = select_jenis_pengadaan($data->jenis_pengadaan);
                return $return;
            })
            ->editColumn('id', function($data) {
                $return  = "<b>$data->no_paket</b>";
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
            ->rawColumns(['pilihan', 'paket', 'pagu', 'jenis', 'id', 'aksi'])->make(true);
    }
}
