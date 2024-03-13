<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Powerball;
use App\Models\Megamillions;
use App\Models\Luckyforlife;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $game = $request->input('game');
        $file = $request->file('file');
        $fileContents = file($file->getPathname());

        $isFirst = true;
        // $i = 0;
        foreach ($fileContents as $line) {
            // $i++;
            // if ($i < 2556) continue;
            if ($isFirst) {
                $isFirst = false;
                continue;
            }

            $data = str_getcsv($line);

            // DATE
            $timestamp = strtotime($data[0]);
            $date = date("Y-m-d", $timestamp);
// var_dump($date);
            
            // WINNING NUMBERS
            $winningNumbers = $data[2];
            // Split the input string into an array of numbers
            $numbersArray = explode(" ", $winningNumbers);

            // Filter out non-numeric values and get the first five numbers
            $filteredNumbers = array_filter($numbersArray, 'is_numeric');

            // WINNING COLUMN
            $firstFiveNumbers = array_slice($filteredNumbers, 0, 5);

            // Convert the array of numbers into a comma-separated string
            $winningColumn = implode(",", $firstFiveNumbers);

// var_dump($winningColumn);  // Output: 6,28,59,62,69

            // BALANDER
            // var_dump($filteredNumbers);die;
            $balander = intval($filteredNumbers[5]);
// var_dump($balander);

            // MULTIPLIER
            $multiplier = null;
            // Regular expression to match a number followed by 'x'
            $pattern = '/(\d+)x/';

            // Perform the search
            if (preg_match($pattern, $winningNumbers, $matches)) {
                // Extract the matched number
                $multiplier = $matches[1];
            }
// var_dump($multiplier);

            switch ($game) {
                case 'luckyforlife':
                    Luckyforlife::create([
                        'draw_date' => $date,
                        'winning_column' => $winningColumn,
                        'balander' => $balander
                    ]);
                    break;
                case 'megamillions':
                    Megamillions::create([
                        'draw_date' => $date,
                        'winning_column' => $winningColumn,
                        'balander' => $balander,
                        'multiplier' => $multiplier
                    ]);
                    break;
                case 'powerball':
                default:
                    Powerball::create([
                        'draw_date' => $date,
                        'winning_column' => $winningColumn,
                        'balander' => $balander,
                        'multiplier' => $multiplier
                    ]);
                    break;
            }

            // die;
        }
        session()->flash('success_message', 'File uploaded successfully!');

        return redirect()->back(); // Redirect back to the form page
        // return redirect()->back()->with('success', 'CSV file imported successfully.');
    }
}
