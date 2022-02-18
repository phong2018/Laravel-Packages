<?php
namespace Phonglg\LaravelBackup\Controllers;

use Carbon\Carbon;
use Phonglg\LaravelBackup\Helpers\BackupHelper;
use Illuminate\Support\Facades\Artisan; 
use Illuminate\Routing\Controller; 
use League\Flysystem\Adapter\Local;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Gate;

class BackupController extends Controller
{

    public function index()
    {  
        if (!Gate::allows('backupDB')) {abort(403);}

        $this->data['backups'] = [];
        
        $disk_name=config('laravelbackup.name'); 

        $disk = Storage::disk($disk_name);
       
        $adapter = $disk->getDriver()->getAdapter();
        
        $files = $disk->allFiles(); 
        

        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                if($k<90)
                    $this->data['backups'][] = [
                        'file_name'     => $f, 
                        'file_size'     => $disk->size($f),
                        'last_modified' => $disk->lastModified($f),
                        'disk'          => $disk_name,
                        'download'      => ($adapter instanceof Local) ? true : false,
                    ];
                else{
                    $disk->delete($f); 
                } 
            }
        }
         
        // reverse the backups, so the newest one would be on top
        $this->data['backups'] = array_reverse($this->data['backups']);
        $this->data['title'] = 'Backups';

        return view('laravelbackup::backup', $this->data);
    } 

    public function create()
    {
        if (!Gate::allows('backupDB')) {abort(403);}
        BackupHelper::createBackup();
        

        return redirect()->route('backup.index'); 
    }

    /**
     * Downloads a backup zip file.
     */
    public function download($vdisk,$vfileName)
    {
        if (!Gate::allows('backupDB')) {abort(403);}

        $disk = Storage::disk($vdisk);
        $file_name = $vfileName;
        $adapter = $disk->getDriver()->getAdapter();

        if ($adapter instanceof Local) {
            $storage_path = $disk->getDriver()->getAdapter()->getPathPrefix();

            if ($disk->exists($file_name)) {
                return response()->download($storage_path.$file_name);
            } else {
                abort(404, 'Backup does not exist');
            }
        } else {
            abort(404, 'Only local downloads supported');
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete($vdisk,$vfileName)
    {
        if (!Gate::allows('backupDB')) {abort(403);}

        $disk = Storage::disk($vdisk);

        if ($disk->exists($vfileName)) {
            $disk->delete($vfileName);
        } else {
            abort(404, trans('laravelbackup::backup.backup_doesnt_exist'));
        }

        return redirect()->route('backup.index'); 
    }
}