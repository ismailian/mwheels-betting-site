<?php

## extract query params ##

if (Request::query_has("type") && Request::query_has("number")) {

    $query  = Request::query_as_object();
    $type   = Sanitizer::integer($query->type);
    $number = Sanitizer::string($query->number);
    ## sanitize ##

    ## filter ##
    if (empty($type) || empty($number)) {

        ## redirect back to wheels ##
        Redirector::route("admin/wheels.php");
        return;
        ## redirect back to wheels ##

    }

    ## placeholders ##
    $spots = [];
    ## placeholders ##

    for ($i = 0; $i < 10; $i++) {

        ## check if is taken:
        $isTaken = false;
        $takenBy = "Available";

        $isTaken = Spot::is_taken($type, $number, $i);

        if ($isTaken) {
            ## fetch ##
            $spot    = Spot::info(['wheel_type' => $type, 'wheel_number' => $number, 'wheel_spot' => $i], ['user_id']);
            $takenBy = ($spot) ? User::get($spot->user_id, ['username'])->username : "Available";
            ## fetch ##
        }

        array_push($spots, (object) [
            'id'      => ("0" . $i),
            'isTaken' => $isTaken,
            'takenBy' => $takenBy,
        ]);
    }

    $data = (object) [
        'type'   => Type::get(['type' => $type], ['name'])->name,
        'number' => $number,
        'spots'  => $spots,
    ];
}
