<?php require_once('./App.php'); ?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
   <meta charset="utf-8" />
   <title>MTL Wheels Dashboard</title>
   <meta name="description" content="Datatable local sorting" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <!--begin::Fonts-->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
   <!--end::Fonts-->
   <!--begin::Global Theme Styles(used by all pages)-->
   <link href="dist/plugins/global/plugins.bundlec3e8.css?v=7.0.6" rel="stylesheet" type="text/css" />
   <link href="dist/plugins/custom/prismjs/prismjs.bundlec3e8.css?v=7.0.6" rel="stylesheet" type="text/css" />
   <link href="dist/css/style.bundlec3e8.css?v=7.0.6" rel="stylesheet" type="text/css" />
   <link href="dist/css/pages/wizard/wizard-4c3e8.css?v=7.0.6" rel="stylesheet" type="text/css" />
   <!--end::Global Theme Styles-->
   <!--begin::Layout Themes(used by all pages)-->
   <!--end::Layout Themes-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-static page-loading">
   <!--begin::Main-->
   <!--begin::Header Mobile-->
   <div id="kt_header_mobile" class="header-mobile header-mobile-fixed">
      <!--begin::Logo-->
      <a href="../../../index.html">
         <img alt="Logo" src="dist/media/logos/logo-letter-1.png" class="logo-default max-h-30px" />
      </a>
      <!--end::Logo-->
      <!--begin::Toolbar-->
      <div class="d-flex align-items-center">
         <button class="btn p-0 burger-icon rounded-0 burger-icon-left" id="kt_aside_tablet_and_mobile_toggle">
            <span></span>
         </button>
         <button class="btn btn-hover-text-primary p-0 ml-3" id="kt_header_mobile_topbar_toggle">
            <span class="svg-icon svg-icon-xl">
               <!--begin::Svg Icon |-->
               <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                     <polygon points="0 0 24 0 24 24 0 24" />
                     <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                     <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                  </g>
               </svg>
               <!--end::Svg Icon-->
            </span>
         </button>
      </div>
      <!--end::Toolbar-->
   </div>
   <!--end::Header Mobile-->
   <div class="d-flex flex-column flex-root">
      <!--begin::Page-->
      <div class="d-flex flex-row flex-column-fluid page">
         <!--begin::Aside-->
         <div class="aside aside-left d-flex flex-column flex-row-auto" id="kt_aside">
            <?php include "includes/menu.php"; ?>
         </div>
         <!--end::Aside-->
         <!--begin::Wrapper-->
         <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <!--begin::Header-->
            <?php include "includes/header.php"; ?>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
               <!--begin::Subheader-->
               <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
                  <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                     <!--begin::Info-->
                     <div class="d-flex align-items-center flex-wrap mr-1">
                        <!--begin::Page Heading-->
                        <div class="d-flex align-items-baseline flex-wrap mr-5">
                           <!--begin::Page Title-->
                           <h2 class="subheader-title text-dark font-weight-bold my-1 mr-3">Edit Pages</h2>
                           <!--end::Page Title-->
                           <!--begin::Breadcrumb-->
                           <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold my-2 p-0">
                              <li class="breadcrumb-item">
                                 <a href="index.php" class="text-muted">Dashboard</a>
                              </li>
                              <li class="breadcrumb-item">
                                 <a href="" class="text-muted">Edit Draws G.2</a>
                              </li>
                           </ul>
                           <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page Heading-->
                     </div>
                     <!--end::Info-->
                  </div>
               </div>
               <!--end::Subheader-->
               <!--begin::Entry-->
               <div class="d-flex flex-column-fluid">
                  <!--begin::Container-->
                  <div class="container">
                     <!--begin::Card-->
                     <div class="card card-custom">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                           <div class="card-title">
                              <h3 class="card-label">Edit Draws G.2
                                 <span class="d-block text-muted pt-2 font-size-sm">Setting up your Draws G.2 now</span>
                              </h3>
                           </div>
                        </div>
                        <div class="card-body">
                           <!--begin: Wizard-->
                           <div class="wizard wizard-4" id="kt_wizard_v4" data-wizard-state="step-first" data-wizard-clickable="true">
                              <!--begin: Wizard Nav-->
                              <div class="wizard-nav">
                                 <div class="wizard-steps">

                                    <div class="wizard-step mt-3" data-wizard-type="step">
                                       <div class="wizard-wrapper">
                                          <div class="wizard-number">4</div>
                                          <div class="wizard-label">
                                             <div class="wizard-title">Draw 4</div>
                                             <div class="wizard-desc">Customize your wheels.</div>
                                          </div>
                                       </div>
                                    </div>
                                    <!--end::Wizard Step 3 Nav-->
                                    <div class="wizard-step mt-3" data-wizard-type="step">
                                       <div class="wizard-wrapper">
                                          <div class="wizard-number">5</div>
                                          <div class="wizard-label">
                                             <div class="wizard-title">Draw 5</div>
                                             <div class="wizard-desc">Check taken spots.</div>
                                          </div>
                                       </div>
                                    </div>
                                    <!--end::Wizard Step 3 Nav-->
                                    <div class="wizard-step mt-3" data-wizard-type="step">
                                       <div class="wizard-wrapper">
                                          <div class="wizard-number">6</div>
                                          <div class="wizard-label">
                                             <div class="wizard-title">Draw 6</div>
                                             <div class="wizard-desc">and reset everything.</div>
                                          </div>
                                       </div>
                                    </div>
                                    <!--end::Wizard Step 3 Nav-->
                                 </div>
                              </div>
                              <!--end: Wizard Nav-->
                              <!--begin: Wizard Body-->
                              <div class="card card-custom card-shadowless rounded-top-0">
                                 <div class="card-body p-0">
                                    <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                                       <div class="col-xl-12 col-xxl-7" id="kt_form">
                                          <!--begin: Wizard Form-->

                                          <!--end: Wizard Form-->
                                          <div id="page04" class="pb-5" data-wizard-type="step-content">
                                             <div class="row justify-content-center">
                                                <div class="col-lg-6">
                                                   <div class="form-group">
                                                      <label>Name :</label>
                                                      <input type="text" id="pagename" class="form-control" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label>Odds :</label>
                                                      <input type="text" id="pageodds" class="form-control" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label>Prize :</label>
                                                      <input type="number" id="pageprize" class="form-control" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label>Entry : </label>
                                                      <input type="float" id="pageentry" class="form-control" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label>Status : </label>
                                                      <select class="form-control" id="pagestatus">
                                                         <option value="1">Allowed</option>
                                                         <option value="0">Not Allowed</option>
                                                      </select>
                                                   </div>
                                                   <button onclick="javascript:editPageFour();" class="btn btn-primary font-weight-bolder float-right">Save changes</button>
                                                </div>
                                             </div>
                                          </div>
                                          <!--end: Wizard Step 3-->
                                          <!--end: Wizard Form-->
                                          <div id="page05" class="pb-5" data-wizard-type="step-content">
                                             <div class="row justify-content-center">
                                                <div class="col-lg-6">
                                                   <div class="form-group">
                                                      <label>Name :</label>
                                                      <input type="text" id="pagename" class="form-control" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label>Odds :</label>
                                                      <input type="text" id="pageodds" class="form-control" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label>Prize :</label>
                                                      <input type="number" id="pageprize" class="form-control" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label>Entry : </label>
                                                      <input type="float" id="pageentry" class="form-control" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label>Status : </label>
                                                      <select class="form-control" id="pagestatus">
                                                         <option value="1">Allowed</option>
                                                         <option value="0">Not Allowed</option>
                                                      </select>
                                                   </div>
                                                   <button onclick="javascript:editPageFive();" class="btn btn-primary font-weight-bolder float-right">Save changes</button>
                                                </div>
                                             </div>
                                          </div>
                                          <!--end: Wizard Step 3-->
                                          <!--end: Wizard Form-->
                                          <div id="page06" class="pb-5" data-wizard-type="step-content">
                                             <div class="row justify-content-center">
                                                <div class="col-lg-6">
                                                   <div class="form-group">
                                                      <label>Name :</label>
                                                      <input type="text" id="pagename" class="form-control" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label>Odds :</label>
                                                      <input type="text" id="pageodds" class="form-control" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label>Prize :</label>
                                                      <input type="number" id="pageprize" class="form-control" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label>Entry : </label>
                                                      <input type="float" id="pageentry" class="form-control" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label>Status : </label>
                                                      <select class="form-control" id="pagestatus">
                                                         <option value="1">Allowed</option>
                                                         <option value="0">Not Allowed</option>
                                                      </select>
                                                   </div>
                                                   <button onclick="javascript:editPageSix();" class="btn btn-primary font-weight-bolder float-right">Save changes</button>
                                                </div>
                                             </div>
                                          </div>
                                          <!--end: Wizard Step 3-->
                                          <!--end: Wizard Form-->
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!--end: Wizard Bpdy-->
                           </div>
                           <!--end: Wizard-->
                        </div>
                     </div>
                     <!--end::Card-->
                  </div>
                  <!--end::Container-->
               </div>
               <!--end::Entry-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <?php include "includes/footer.php"; ?>
            <!--end::Footer-->
         </div>
         <!--end::Wrapper-->
      </div>
      <!--end::Page-->
   </div>
   <!--end::Main-->
   <!--begin::Scrolltop-->
   <div id="kt_scrolltop" class="scrolltop">
      <span class="svg-icon">
         <!--begin::Svg Icon | path:/metronic/theme/html/demo5/dist/media/svg/icons/Navigation/Up-2.svg-->
         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
               <polygon points="0 0 24 0 24 24 0 24" />
               <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
               <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
            </g>
         </svg>
         <!--end::Svg Icon-->
      </span>
   </div>
   <!--end::Scrolltop-->
   <!--begin::Global Config(global config for global JS scripts)-->
   <script>
      var KTAppSettings = {
         "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1200
         },
         "colors": {
            "theme": {
               "base": {
                  "white": "#ffffff",
                  "primary": "#6993FF",
                  "secondary": "#E5EAEE",
                  "success": "#1BC5BD",
                  "info": "#8950FC",
                  "warning": "#FFA800",
                  "danger": "#F64E60",
                  "light": "#F3F6F9",
                  "dark": "#212121"
               },
               "light": {
                  "white": "#ffffff",
                  "primary": "#E1E9FF",
                  "secondary": "#ECF0F3",
                  "success": "#C9F7F5",
                  "info": "#EEE5FF",
                  "warning": "#FFF4DE",
                  "danger": "#FFE2E5",
                  "light": "#F3F6F9",
                  "dark": "#D6D6E0"
               },
               "inverse": {
                  "white": "#ffffff",
                  "primary": "#ffffff",
                  "secondary": "#212121",
                  "success": "#ffffff",
                  "info": "#ffffff",
                  "warning": "#ffffff",
                  "danger": "#ffffff",
                  "light": "#464E5F",
                  "dark": "#ffffff"
               }
            },
            "gray": {
               "gray-100": "#F3F6F9",
               "gray-200": "#ECF0F3",
               "gray-300": "#E5EAEE",
               "gray-400": "#D6D6E0",
               "gray-500": "#B5B5C3",
               "gray-600": "#80808F",
               "gray-700": "#464E5F",
               "gray-800": "#1B283F",
               "gray-900": "#212121"
            }
         },
         "font-family": "Poppins"
      };
   </script>
   <!--end::Global Config-->
   <!--begin::Global Theme Bundle(used by all pages)-->
   <script src="dist/plugins/global/plugins.bundlec3e8.js?v=7.0.6"></script>
   <script src="dist/plugins/custom/prismjs/prismjs.bundlec3e8.js?v=7.0.6"></script>
   <script src="dist/js/scripts.bundlec3e8.js?v=7.0.6"></script>
   <!--end::Global Theme Bundle-->
   <!--begin::Page Scripts(used by this page)-->
   <script src="dist/js/pages/custom/wizard/wizard-4c3e8.js"></script>
   <!--end::Page Scripts-->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.all.min.js"></script>
   <script src="dist/js/editpages.js"></script>
   <script src="dist/js/main.js"></script>
</body>
<!--end::Body-->

</html>