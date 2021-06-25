<?php

namespace Modules\PPID\Http\Controllers\Plugin;

use Modules\Core\Http\Controllers\CoreController as Controller;
use Illuminate\Http\Request;

use Modules\PPID\Entities\Plugin\SOP;

class SOPController extends Controller
{
    protected $title = 'SOP Kegiatan';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Model
     */
    public function __construct(SOP $data) 
    {
        $this->data = $data;

        $this->toIndex = route('epanel.sop.index');
        $this->prefix = 'epanel.sop';
        $this->view = 'ppid::plugin.sop';

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
            'judul' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png'
        ]);

        $input = $request->all();
        
        $input['id_operator'] = auth()->user()->id;
        if($request->hasFile('file')):
            $input['file'] = $this->upload($request->file('file'), uuid());
        endif;

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
            'judul' => 'required',
            'file' => 'mimes:jpg,jpeg,png'
        ]);

        $input = $request->all();
        if($request->hasFile('file')):
            deleteImg($edit->file);
            $input['file'] = $this->upload($request->file('file'), $edit->uuid);
        else:
            $input['file'] = $edit->file;
        endif;

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
                deleteImg($each->file);
                $each->delete();
            endforeach;
            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
    }

    /**
     * Upload Logic
     * 
     * @param  $file, $filename
     * @return URI
     */
    public function upload($file, $filename) 
    {
        $tmpFilePath = 'app/public/Plugin/';
        $tmpFileDate =  date('Y-m') .'/'.date('d').'/';
        $tmpFileName = $filename;
        $tmpFileExt = $file->getClientOriginalExtension();

        makeImgDirectory($tmpFilePath . $tmpFileDate);
        
        $nama_file = $tmpFilePath . $tmpFileDate . $tmpFileName;
        \Image::make($file->getRealPath())->save(storage_path() . "/$nama_file.$tmpFileExt");

        return "storage/Plugin/{$tmpFileDate}{$tmpFileName}.{$tmpFileExt}";
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
            ->editColumn('judul', function($data) {
                $return  = $data->judul;
                return $return;
            })
            ->editColumn('bidang', function($data) {
                $return  = optional($data->bidang)->label;
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
            ->rawColumns(['pilihan', 'judul', 'bidang', 'aksi'])->make(true);
    }
}
