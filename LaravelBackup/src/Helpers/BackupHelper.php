<?php

namespace Phonglg\LaravelBackup\Helpers;
 
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Artisan;  
use Illuminate\Support\Facades\Log; 
use League\Flysystem\Adapter\Local;


class BackupHelper
{
    public static function getTables() {
		return DB::select('SHOW TABLES');
	}

	public static function backup($tables) {
		$output = '';

		foreach ($tables as $value) {
			
			$table=$value->Tables_in_laravelpackages; 

			$output .= 'TRUNCATE TABLE `' . $table . '`;' . "\n\n";

			$results = DB::select("SELECT * FROM `" . $table . "`");  

			foreach ($results as $result) { 

				$result=(array)$result;

				$fields = '';

				foreach (array_keys($result) as $value) {
					$fields .= '`' . $value . '`, ';
				}

				$values = '';

				foreach (array_values($result) as $value) {
					$value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
					$value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
					$value = str_replace('\\', '\\\\',	$value);
					$value = str_replace('\'', '\\\'',	$value);
					$value = str_replace('\\\n', '\n',	$value);
					$value = str_replace('\\\r', '\r',	$value);
					$value = str_replace('\\\t', '\t',	$value);

					$values .= '\'' . $value . '\', ';
				}

				$output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
			}

			$output .= "\n\n";

		}

		return $output;
	} 


	public static function createBackup() {
		$message = 'success';

        try {
            ini_set('max_execution_time', 600);

            Log::info('Backpack\BackupManager -- Called backup:run from admin interface');

            Artisan::call('backup:run' ,['--only-db' => true]);

            $output = Artisan::output();
            if (strpos($output, 'Backup failed because')) {
                preg_match('/Backup failed because(.*?)$/ms', $output, $match);
                $message = "Backpack\BackupManager -- backup process failed because ";
                $message .= isset($match[1]) ? $match[1] : '';
                Log::error($message.PHP_EOL.$output);
            } else {
                Log::info("Backpack\BackupManager -- backup process has started");
            }
        } catch (Exception $e) {
            Log::error($e);

            return Response::make($e->getMessage(), 500);
        }
	}
}
 