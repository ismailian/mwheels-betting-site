<?php

/*
* This class handles export requests.
*/

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Export
{

    public static function Start()
    {

        # export auditlogs #
        if (Request::query_has('export_auditlogs')) Export::export_auditlogs();
        # export auditlogs #

        # export creditlogs #
        if (Request::query_has('export_creditlogs')) Export::export_creditlogs();
        # export creditlogs #

        # export winners #
        if (Request::query_has('export_winners')) Export::export_winners();
        # export winners #

        # download archive #
        if (Request::query_has('download')) Export::download_archive();
        # download archive #

    }

    // export auditlogs 
    private static function export_auditlogs()
    {

        ## database ##
        global $db;
        ## database ##

        ## export auditlogs ##
        if (Request::query_has('export_auditlogs')) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## generate SpreadSheet ##
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle("Audit_Logs_SpreadSheet");
            ## generate SpreadSheet ##

            ## set the header #
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Confirmation ID');
            $sheet->setCellValue('C1', 'Username');
            $sheet->setCellValue('D1', 'Wheel Type');
            $sheet->setCellValue('E1', 'Wheel Number');
            $sheet->setCellValue('F1', 'Spot Taken');
            $sheet->setCellValue('G1', 'Status');
            $sheet->setCellValue('H1', 'Paid');
            $sheet->setCellValue('I1', 'Date');
            ## set the header ##

            ##########################################
            ## loop through data and fill the sheet ##
            ##########################################
            ## fetch ##
            $logs = $db->getMany(BETS, ['seen' => false], [
                'id', 'cid', 'user_id', 'wheel_type', 'wheel_number', 'wheel_spot', 'choice', 'paid', 'updated_at'
            ]);

            ## audit logs ##
            $auditlogs = [];

            foreach ($logs as $log) {

                // check user first 
                if ($user = User::get($log->user_id, ['username'])) {

                    array_push($auditlogs, (object)[
                        'id'           => $log->id,
                        'cid'          => $log->cid,
                        'username'     => $user->username,
                        'wheel_type'   => $log->wheel_type,
                        'wheel_number' => $log->wheel_number,
                        'wheel_spot'   => $log->wheel_spot,
                        'choice'       => $log->choice,
                        'paid'         => $log->paid,
                        'date'         => (new DateTime($log->updated_at))->format('M d, Y H:i'),
                    ]);
                }
            }

            ## keep track of index ##
            $index = 2;

            ## fill current row ##
            foreach ($auditlogs as $auditlog) {

                ## fill current row #
                $sheet->setCellValue("A{$index}", ($auditlog)->id);
                $sheet->setCellValue("B{$index}", ($auditlog)->cid);
                $sheet->setCellValue("C{$index}", ($auditlog)->username);
                $sheet->setCellValue("D{$index}", ($auditlog)->wheel_type);
                $sheet->setCellValue("E{$index}", ($auditlog)->wheel_number);
                $sheet->setCellValue("F{$index}", ($auditlog)->wheel_spot);
                $sheet->setCellValue("G{$index}", ($auditlog)->choice);
                $sheet->setCellValue("H{$index}", ($auditlog)->paid);
                $sheet->setCellValue("I{$index}", ($auditlog)->date);
                ## fill current row ##

                ## increment index ##
                $index += 1;
            }
            ##########################################
            ## loop through data and fill the sheet ##
            ##########################################

            ## push download ##
            // Redirect output to a client’s web browser (Xlsx)
            $filename = "[auditlogs]_" . (new DateTime('now'))->format('Y_m_d_H_i_s') . "_.xlsx"; //  [auditlogs]_2020_07_31_.xlxs
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');

            ## cach control ##
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Cache-Control: no-cache, max-age=0');
            header('Cache-Control: no-cache, max-age=0, stale-while-revalidate=300');
            ## cach control ##

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Pragma: no-cache'); // HTTP/1.0

            ## save to disk ##
            $saver = new Xlsx($spreadsheet);
            $saver->save(Archive . "/" . $filename);
            ## save to disk ##

            ## save to db ##
            Archive::add($filename);
            ## save to db ##

            // directly write to browser:
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            ## push download ##
        }
        ## export auditlogs ##
    }

    // export credit logs //
    private static function export_creditlogs()
    {

        ## export creditlogs ##
        if (Request::query_has('export_creditlogs')) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## generate SpreadSheet ##
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle("Credit_Logs_SpreadSheet");
            ## generate SpreadSheet ##

            ## set the header #
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Username');
            $sheet->setCellValue('C1', 'Received');
            $sheet->setCellValue('D1', 'From');
            $sheet->setCellValue('E1', 'Date');
            ## set the header ##

            ##########################################
            ## loop through data and fill the sheet ##
            ##########################################
            ## fetch ##
            $creditlogs = Credit::all(['id', 'user_id', 'agent_id', 'amount', 'created_at']);
            ## fetch ##

            ## fix ##
            foreach ($creditlogs as $creditlog) {

                ## agent ##
                $agent = Agent::get($creditlog->agent_id, ['username'], true);
                $agent = ($agent) ? $agent->username : "N/A";
                ($creditlog)->from = strtoupper($agent);

                ## user ##
                $user = User::get($creditlog->user_id, ['username']);
                $user = ($user) ? $user->username : "N/A";
                ($creditlog)->username = $user;

                ## credit ##
                ($creditlog)->received = ($creditlog)->amount;

                ## date ##
                ($creditlog)->date = (new DateTime(($creditlog)->created_at))->format("d M, Y");

                unset($creditlog->agent_id);
                unset($creditlog->user_id);
                unset($creditlog->amount);
                unset($creditlog->created_at);
            }
            ## fix ##

            ## keep track of index ##
            $index = 2;

            ## fill current row ##
            foreach ($creditlogs as $creditlog) {

                ## fill current row #
                $sheet->setCellValue("A{$index}", ($creditlog)->id);
                $sheet->setCellValue("B{$index}", ($creditlog)->username);
                $sheet->setCellValue("C{$index}", ($creditlog)->received);
                $sheet->setCellValue("D{$index}", ($creditlog)->from);
                $sheet->setCellValue("E{$index}", ($creditlog)->date);
                ## fill current row ##

                ## increment index ##
                $index += 1;
            }
            ##########################################
            ## loop through data and fill the sheet ##
            ##########################################

            ## push download ##
            // Redirect output to a client’s web browser (Xlsx)
            $filename = "[creditlogs]_" . (new DateTime('now'))->format('Y_m_d_H_i_s') . "_.xlsx"; //  [creditlogs]_2020_07_31_.xlxs
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');

            ## cach control ##
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Cache-Control: no-cache, max-age=0');
            header('Cache-Control: no-cache, max-age=0, stale-while-revalidate=300');
            ## cach control ##

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Pragma: no-cache'); // HTTP/1.0

            ## save to disk ##
            $saver = new Xlsx($spreadsheet);
            $saver->save(Archive . "/" . $filename);
            ## save to disk ##

            ## save to db ##
            Archive::add($filename);
            ## save to db ##

            // directly write to browser:
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            ## push download ##
        }
        ## export creditlogs ##
    }

    private static function export_winners()
    {
        if (Request::query_has("export_winners")) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## fetch ##
            $winners = Winner::all();
            ## fetch ##

            ## fix ##
            foreach ($winners as $winner) {

                ## user ##
                $user = User::get($winner->user_id, ['username']);
                $user = ($user) ? $user->username : "N/A";
                ($winner)->username = $user;

                ## number ##
                ($winner)->number = ($winner)->wheel_number;

                ## spot ##
                ($winner)->spot = ($winner)->wheel_spot;

                ## date ##
                ($winner)->date = (new DateTime(($winner)->created_at))->format("M d, Y H:i");

                ## unset ##
                unset($winner->user_id);
                unset($winner->wheel_number);
                unset($winner->wheel_spot);
                unset($winner->created_at);
            }
            ## fix ##

            ## generate SpreadSheet ##
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle("Winners_SpreadSheet");
            ## generate SpreadSheet ##

            ## set the header #
            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Confirm ID');
            $sheet->setCellValue('C1', 'Username');
            $sheet->setCellValue('D1', 'Wheel Number');
            $sheet->setCellValue('E1', 'Wheel Spot');
            $sheet->setCellValue('F1', 'Prize');
            $sheet->setCellValue('G1', 'Date');
            ## set the header ##

            ##########################################
            ## loop through data and fill the sheet ##
            ##########################################
            $index = 2;
            foreach ($winners as $winner) {

                ## fill current row #
                $sheet->setCellValue("A{$index}", ($winner)->id);
                $sheet->setCellValue("B{$index}", ($winner)->cid);
                $sheet->setCellValue("C{$index}", ($winner)->username);
                $sheet->setCellValue("D{$index}", ($winner)->number);
                $sheet->setCellValue("E{$index}", ($winner)->spot);
                $sheet->setCellValue("F{$index}", ($winner)->prize);
                $sheet->setCellValue("G{$index}", ($winner)->date);
                ## fill current row ##

                ## increment index ##
                $index += 1;
            }
            ##########################################
            ## loop through data and fill the sheet ##
            ##########################################

            ## Redirect output to a client’s web browser (Xlsx)
            $filename = "[winners]_" . (new DateTime('now'))->format('Y_m_d_H_i_s') . "_.xlsx"; ##  [winners]_2020_07_31_.xlxs
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');

            ## cach control ##
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Cache-Control: no-cache, max-age=0');
            header('Cache-Control: no-cache, max-age=0, stale-while-revalidate=300');
            ## cach control ##

            ## If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 2022 05:00:00 GMT');               ## Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');  ## always modified
            header('Pragma: no-cache');                                      ## HTTP/1.0

            ## save to disk ##
            $saver = new Xlsx($spreadsheet);
            $saver->save(Archive . "/" . $filename);
            ## save to disk ##

            ## save to db ##
            Archive::add($filename);
            ## save to db ##

            ## directly write to browser:
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            ## push download ##

        }
    }

    // download archives //
    private static function download_archive()
    {
        if (Request::query_has('archive')) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## input ##
            $archive_id = Sanitizer::get_integer('archive');
            ## input ##

            ## filter ##
            if (empty($archive_id) || !is_numeric($archive_id)) Response::default_error();
            if (!Archive::exists($archive_id)) Response::default_error();
            ## filter ##

            ## fetch archive filename ##
            $archive = Archive::get($archive_id, ['filename'])->filename;
            ## fetch archive filename ##

            ## download ##
            Download::push(Archive . "/" . $archive, $archive);
            ## download ##

            ## exit ##
            exit();
            ## exit ##

        }
    }
}
