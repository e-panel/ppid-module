<?php

namespace Modules\PPID\Http\Controllers\Unduhan;

use Modules\Core\Http\Controllers\CoreController as Controller;
use Illuminate\Http\Request;

use Modules\PPID\Entities\Unduhan\Kategori;
use Modules\PPID\Entities\Unduhan\File as Unduhan;

class FileController extends Controller
{
    protected $title = 'File Unduhan';

    /**
     * Siapkan konstruktor controller
     * 
     * @param Model
     */
    public function __construct(Unduhan $data, Kategori $kategori) 
    {
        $this->data = $data;
        $this->kategori = $kategori;

        $this->toIndex = route('epanel.unduhan.file.index', request()->segment(4));
        $this->prefix = 'epanel.unduhan';
        $this->view = 'ppid::unduhan.file';

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
    public function index(Request $request, $kategori) 
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        $data = $kategori->unduhan()->latest()->get();

        if($request->has('datatable')):
            return $this->datatable($data, $kategori);
        endif;
        
        return view("$this->view.index", compact('data', 'kategori'));
    }

    /**
     * Tampilkan halaman untuk menambah data
     * 
     * @param  $kategori
     * @return Illuminate\View\View
     */
    public function create($kategori) 
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();

        return view("$this->view.create", compact('kategori'));
    }

    /**
     * Lakukan penyimpanan data ke database
     * 
     * @param  Illuminate\Http\Request
     * @return mixed
     */
    public function store(Request $request, $kategori) 
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        
        $this->validate($request, [
            'judul' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar'
        ]);

        $input = $request->all();
        $input['id_operator'] = auth()->user()->id;
        $input['id_kategori'] = $kategori->id;

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
    public function show($kategori, $id)
    {
        return abort(404);
    }

    /**
     * Tampilkan halaman perubahan data
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Illuminate\View\View
     */
    public function edit($kategori, $id) 
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        $edit = $this->data->uuid($id)->firstOrFail();
    
        return view("$this->view.edit", compact('edit', 'kategori'));
    }

    /**
     * Lakukan perubahan data sesuai dengan data yang diedit
     * 
     * @param  $id [ID dari data yang dipilih]
     * @return Back [Tampilkan halaman yang sama]
     */
    public function update(Request $request, $kategori, $id) 
    {
        $kategori = $this->kategori->uuid($kategori)->firstOrFail();
        $edit = $this->data->uuid($id)->firstOrFail();

        $this->validate($request, [
            'judul' => 'required'
        ]);
    
        $input = $request->all();
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
    public function destroy(Request $request, $kategori, $id) 
    {
        if($request->has('pilihan')):
            foreach($request->pilihan as $temp):
                $each = $this->data->uuid($temp)->firstOrFail();
                deleteFile($each->file);
                $each->delete();
            endforeach;
            
            notify()->flash($this->tDelete, 'success');
            return redirect()->back();
        endif;
    }

    /**
     * Function for Upload File
     * 
     * @param  $file, $filename
     * @return URI
     */
    public function upload($file, $filename) 
    {
        $tmpFilePath = 'app/public/Unduhan/';
        $tmpFileDate =  date('Y-m') .'/'.date('d').'/';
        $tmpFileName = $filename;
        $tmpFileExt = $file->getClientOriginalExtension();

        makeImgDirectory($tmpFilePath . $tmpFileDate);
        $nama_file = $tmpFilePath . $tmpFileDate . $tmpFileName;

        $file->move(storage_path() . '/' . $tmpFilePath . $tmpFileDate, $tmpFileName . '.' . $tmpFileExt);

        return "storage/Unduhan/{$tmpFileDate}{$tmpFileName}.{$tmpFileExt}";
    }

    /**
     * Datatable API
     * 
     * @param  $data
     * @return Datatable
     */
    public function datatable($data, $kategori) 
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
            ->editColumn('label', function($data) {
                $return = $data->judul;
                $return .= '<div class="font-11 color-blue-grey-lighter">';
                if(asset($data->file)):
                    $return .= '<i class="fa fa-check"></i> OK';
                else:
                    $return .= '<i class="fa fa-times"></i> Not Exist';
                endif;
                $return .= '</div>';
                return $return;
            })
            ->editColumn('download', function($data) {
                $return  = '<div class="font-11 color-blue-grey-lighter uppercase">Download (s)</div>';
                $return .= $data->download . ' Kali';
                return $return;
            })
            ->editColumn('oleh', function($data) {
                $return  = '<img src="'. \Avatar::create(optional($data->operator)->nama)->toBase64() .'" ';
                $return .= '    data-toggle="tooltip" data-placement="top" data-original-title="Posted by '.optional($data->operator)->nama.'">';
                return $return;
            })
            ->editColumn('created_at', function($data) {
                \Carbon\Carbon::setLocale('id');
                $return  = '<small>' . date('Y-m-d h:i:s', strtotime($data->created_at)) . '</small><br/>';
                $return .= str_replace('yang ', '', $data->created_at->diffForHumans());
                return $return;
            })
            ->editColumn('aksi', function($data) use ($kategori) {
                $return  = '<div class="btn-toolbar">';
                $return .= '    <div class="btn-group btn-group-sm">';
                $return .= '        </a><a href="'. route("$this->prefix.file.edit", [$kategori->uuid, $data->uuid]) .'" role="button" class="btn btn-sm btn-primary-outline">';
                $return .= '            <span class="fa fa-pencil"></span>';
                $return .= '        </a>';
                $return .= '    </div>';
                $return .= '</div>';
                return $return;
            })
            ->rawColumns(['pilihan', 'label', 'download', 'created_at', 'oleh', 'aksi'])->make(true);
    }
}
