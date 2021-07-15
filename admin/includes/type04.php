<!-- template -->
<div class="row justify-content-center">

    <!-- type 1 -->
    <?php foreach (Wheel::all(['type_id' => 4]) as $wheel) : ?>

        <!-- create a wheel -->
        <div class="col-lg-3 mb-5">
            <a href="wheel.php?type=4&number=<?= ($wheel->wheel_number) ?>">
                <div class="card">
                    <span class="svg-icon svg-icon-primary svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" viewBox="0 0 24 24" version="1.1" style="height:100%!important;width:100%!important">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <h4 class="title text-center text-dark"><a href="wheel.php?type=4&number=<?= ($wheel->wheel_number) ?>">Wheel <?= ($wheel->wheel_number) ?></a></h4>
                </div>
            </a>
        </div>

    <?php endforeach ?>

</div>