<?php


class Archive
{


    // Add new archive to database //
    public static function add($filename)
    {
        ## database ##
        global $db;
        ## database ##

        ## store ##
        return $db->put(ARCHIVE, [
            'filename'     => $filename,
            'generated_by' => Sessioneer::user()->username,
        ]);
        ## store ##
    }

    // remove an archive //
    public static function remove($id)
    {
        ## database ##
        global $db;
        ## database ##

        ## remove file ##
        $filename = Archive . "/" . Archive::get($id, ['filename'])->filename;
        if (file_exists($filename)) unlink($filename);
        ## remove file ##

        ## remove and return ##
        return $db->revoke(ARCHIVE, ['id' => $id]);
        ## remove and return ##
    }

    // check if an archive exists //
    public static function exists($id)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $archive = $db->getOne(ARCHIVE, ['id' => $id], ['id']);
        ## fetch ##

        ## return ##
        return ($archive) ? true : false;
        ## return ##
    }

    // get and archive //
    public static function get($id, $fields = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        return $db->getOne(ARCHIVE, ['id' => $id], !is_null($fields) ? $fields : ['id']);
        ## fetch ##
    }

    // collect all archives //
    public static function all()
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $archives = $db->getMany(ARCHIVE);
        ## fetch ##

        ## fix dates ##
        $index = 0;
        foreach ($archives as $archive) {

            $archive->date = (new DateTime($archive->created_at))->format('M d, Y H:i');
            $archive->username   = ($archive->generated_by);

            ## dispose ##
            unset($archive->generated_by);
            ## dispose ##

            ## check if file exists ##
            if (!file_exists(Archive . "/" . $archive->filename)) {


                ## remove form db ##
                Archive::remove($archive->id);
                ## remove form db ##

                ## remove from archive ##
                unset($archives[$index]);
                ## remove from archive ##

            }
            ## check if file exists ##

            ## increment index ##
            $index++;
            ## increment index ##
        }
        ## fix dates ##

        ## return ##
        return $archives;
        ## return ##
    }
}
