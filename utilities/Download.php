<?php

class Download
{

    // push download of a file //
    public static function push($fullpath, $filename, $contentType = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
    {

        ## Redirect output to a client’s web browser ##
        header('Content-Type: ' . $contentType);
        header('Content-Disposition: attachment;filename="' . $filename . '"');

        ## cach control ##
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: no-cache, max-age=0');
        header('Cache-Control: no-cache, max-age=0, stale-while-revalidate=300');
        ## cach control ##

        ## If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 2022 05:00:00 GMT');                ## Date in the future.
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');   ## always modified
        header('Pragma: no-cache');                                      ## HTTP/1.0

        ## source and distination streams ##
        $sourceStream = fopen($fullpath, 'rb');
        $distStream   = fopen('php://output', 'wb');
        ## source and distination streams ##

        ## push download as a stream ##
        stream_copy_to_stream($sourceStream, $distStream);
        ob_flush();
        flush();
        ## push download as a stream ##

    }
}
