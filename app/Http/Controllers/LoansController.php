<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ForbesTop;
use Illuminate\Http\Response;

class ForbesTopController extends Controller
{
    const columnLength = [
        "Count" => 7
    ];

    const columnNames = [
        'Year',
        'Rank',
        'Recipient',
        'Country',
        'Career',
        'Tied',
        'Title'
    ];

    public function uploadCSVContent(Request $request)
    {
        $response = [];

        $file = $request->file('file');
        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();

            //Check for file extension and size
            $validateResponseFile = $this->checkUploadedFileProperties($extension, $fileSize);
            if($this->checkUploadedFileProperties($extension, $fileSize) !== "") {
                $response['message'] = $validateResponseFile;
                $response['link'] = 'csv-upload';

                return view('message', compact('response'))->render();
            }

            $location = 'uploads';
            $file->move($location, $filename);
            $filepath = public_path($location . "/" . $filename);

            // Reading file
            $file = fopen($filepath, "r");
            $importData_arr = array();
            $i = 0;

            //Read the contents of the uploaded file
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);

                // Do validations on headers
                if ($i == 0) {
                    $i++;
                    $validateResponse = $this->checkUploadedFileTemplate($filedata);
                    if($this->checkUploadedFileTemplate($filedata) !== "") {
                        $response['message'] = $validateResponse;
                        $response['link'] = 'csv-upload';

                        return view('message', compact('response'))->render();
                    }
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file);

            // Clear database contents on validations success
            DB::beginTransaction();
                ForbesTop::truncate();
            DB::commit();

            $j = 0;
            foreach ($importData_arr as $importData) {
                $j++;

                try {
                    // Insert individual records to database
                    DB::beginTransaction();
                        ForbesTop::create([
                            'year' => $importData[0],
                            'rank' => $importData[1],
                            'recipient' => $importData[2],
                            'country' => $importData[3],
                            'career' => $importData[4],
                            'tied' => $importData[5],
                            'title' => $importData[6]
                        ]);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    $response['message'] = "$e uploading records failed.";
                    $response['link'] = 'csv-upload';

                    return view('message', compact('response'))->render();
                }
            }

            $response['message'] = "$j records successfully uploaded.";
            $response['link'] = 'csv-upload';

            return view('message', compact('response'))->render();
        } else {
            //no file was uploaded
            $response['message'] = "No file was uploaded.";
            $response['link'] = 'csv-upload';

            return view('message', compact('response'))->render();
        }
    }

    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv");
        $maxFileSize = 20097152;
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                return "No file was uploaded.";
            }
        } else {
            return "Invalid file extension.";
        }

        return "";
    }

    public function checkUploadedFileTemplate($recordEntry)
    {
        $length = count($recordEntry);

        if($this::columnLength['Count'] !== $length) return "Template Column Count[".$length."] not matched ".$this::columnLength['Count'];

        for ($i=0; $i < $length; $i++) {
            if($this::columnNames[$i] !== $recordEntry[$i]) return "Template Column Names not matched.";
        }

        return "";
    }

    public function getRecipients(){
        $recipients = ForbesTop::all();

        return view('records', compact('recipients'))->render();
    }

    public function findRecipients(Request $request){
        $recipients = ForbesTop::query()
            ->where(strtolower($request->type), $request->search)
            ->get();

        return view('records', compact('recipients'))->render();
    }

    public function getMostCounts()
    {
        $dashboardCollections = [];

        $mostPerson = ForbesTop::groupBy('recipient')
            ->select('recipient', DB::raw('count(*) as total'))
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
        $mostPersonNames = $mostPerson->pluck('recipient')->toArray();
        $mostPersonTotals = $mostPerson->pluck('total')->toArray();

        $mostCountry = ForbesTop::groupBy('country')
            ->select('country', DB::raw('count(*) as total'))
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
        $mostCountryNames = $mostCountry->pluck('country')->toArray();
        $mostCountryTotals = $mostCountry->pluck('total')->toArray();

        $mostCareer = ForbesTop::groupBy('career')
            ->select('career', DB::raw('count(*) as total'))
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
        $mostCareerNames = $mostCareer->pluck('career')->toArray();
        $mostCareerTotals = $mostCareer->pluck('total')->toArray();


        $dashboardCollections['most_top_recipient'] = ['name' => $mostPerson[0]->recipient ?? '', 'total' => $mostPerson[0]->total ?? 0];
        $dashboardCollections['most_top_country'] = ['name' => $mostCountry[0]->country ?? '', 'total' => $mostCountry[0]->total ?? 0];
        $dashboardCollections['most_top_career'] = ['name' => $mostCareer[0]->career ?? '', 'total' => $mostCareer[0]->total ?? 0];
        $dashboardCollections['list_top_recipients'] = ['names' => $mostPersonNames, 'totals' => $mostPersonTotals];
        $dashboardCollections['list_top_countries'] = ['names' => $mostCountryNames, 'totals' => $mostCountryTotals];
        $dashboardCollections['list_top_careers'] = ['names' => $mostCareerNames, 'totals' => $mostCareerTotals];

        return view('dashboard', compact('dashboardCollections'))->render();
    }
}
