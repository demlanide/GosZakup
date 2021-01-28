<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="TheAdmin - Responsive admin and web application ui kit">
    <meta name="keywords" content="admin, dashboard, web app, sass, ui kit, ui framework, bootstrap">

    <title>Результат фильтрования</title>

    <!-- Styles -->
    <link href="../../assets/css/core.min.css" rel="stylesheet">
    <link href="../../assets/css/app.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="../../assets/img/apple-touch-icon.png">
    <link rel="icon" href="../../assets/img/favicon.png">
  </head>

  <body>


    <!-- Preloader -->
    <div class="preloader">
      <div class="spinner-dots">
        <span class="dot1"></span>
        <span class="dot2"></span>
        <span class="dot3"></span>
      </div>
    </div>


    <!-- Sidebar -->
    <aside class="sidebar sidebar-expand-lg sidebar-light sidebar-sm sidebar-color-info">

      <header class="sidebar-header bg-info">
        <span class="logo">
          <a href="index.html">Админ панель</a>
        </span>
        <span class="sidebar-toggle-fold"></span>
      </header>

      <nav class="sidebar-navigation">
        <ul class="menu menu-sm menu-bordery">

          <li class="menu-item">
            <a class="menu-link" href="index.html">
              <span class="icon ti-home"></span>
              <span class="title">Панель</span>
            </a>
          </li>

          <li class="menu-item">
            <a class="menu-link" href="clients.html">
              <span class="icon ti-user"></span>
              <span class="title">Пользователи</span>
            </a>
          </li>

          <li class="menu-item">
            <a class="menu-link" href="products.html">
              <span class="icon ti-briefcase"></span>
              <span class="title">Импорт</span>
            </a>
          </li>

          <li class="menu-item active">
            <a class="menu-link" href="invoices.html">
              <span class="icon ti-receipt"></span>
              <span class="title">Список тендеров</span>
              <span class="badge badge-pill badge-info">2</span>
            </a>
          </li>

          <li class="menu-item">
            <a class="menu-link" href="settings.html">
              <span class="icon ti-settings"></span>
              <span class="title">Настройки</span>
            </a>
          </li>

        </ul>
      </nav>

    </aside>
    <!-- END Sidebar -->



    <!-- Topbar -->
    <header class="topbar">
      <div class="topbar-left">
        <span class="topbar-btn sidebar-toggler"><i>&#9776;</i></span>
        <a class="logo d-lg-none" href="index.html"><img src="assets/img/logo.png" alt="logo"></a>

        <ul class="topbar-btns">

  <h3>Список тендеров</h3>

        </ul>
      </div>

      <div class="topbar-right">

        <ul class="topbar-btns">
          <li class="dropdown">
            <span class="topbar-btn" data-toggle="dropdown"><img class="avatar" src="assets/img/logo-thetheme.png" alt="..."></span>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="#"><i class="ti-user"></i> Profile</a>
              <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
              <a class="dropdown-item" href="#"><i class="ti-help"></i> Help</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#"><i class="ti-power-off"></i> Logout</a>
            </div>
          </li>
        </ul>

        <form class="lookup lookup-circle lookup-right" target="index.html">
          <input type="text" name="s">
        </form>

      </div>
    </header>
    <!-- END Topbar -->



    <!-- Main container -->
    <main>


      <div class="main-content">

        <div class="media-list media-list-divided media-list-hover" data-provide="selectall">

          <header class="flexbox align-items-center media-list-header bg-transparent b-0 py-16 pl-20">
            <div class="flexbox align-items-center">
              <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-indicator"></span>
              </label>

              <span class="divider-line mx-1"></span>

              <div class="dropdown">
                <a class="btn btn-sm dropdown-toggle" data-toggle="dropdown" href="#">Sort by</a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#">Create Date</a>
                  <a class="dropdown-item" href="#">Due Date</a>
                  <a class="dropdown-item" href="#">Client</a>
                  <a class="dropdown-item" href="#">Amount</a>
                  <a class="dropdown-item" href="#">Status</a>
                </div>
              </div>
            </div>

            <div>
              <div class="lookup lookup-circle lookup-right">
                <input type="text" data-provide="media-search">
              </div>
            </div>
          </header>


          <div class="media-list-body bg-white b-1">
            <div class="media align-items-center">
              <label class="custom-control custom-checkbox pr-12">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-indicator"></span>
              </label>

              <a class="flexbox align-items-center flex-grow gap-items text-truncate" href="#qv-user-details" data-toggle="quickview">
                <img class="avatar" src="assets/img/avatar/1.jpg" alt="...">

                <div class="media-body text-truncate">
                  <h6>Тендер на закупки</h6>
                  <small>
                    <span>#68435</span>
                    <span class="divider-dash">09.10.2020</span>
                    <span class="divider-dash"><span class="text-warning">Подписание</span></span>
                  </small>
                </div>
              </a>

              <span class="lead text-fade">345 500₸</span>
            </div>


            <div class="media align-items-center">
              <label class="custom-control custom-checkbox pr-12">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-indicator"></span>
              </label>

              <a class="flexbox align-items-center flex-grow gap-items text-truncate" href="#qv-user-details" data-toggle="quickview">
                <img class="avatar" src="assets/img/avatar/2.jpg" alt="...">

                <div class="media-body text-truncate">
                  <h6>Тендер на закупки</h6>
                  <small>
                    <span>#68531</span>
                    <span class="divider-dash">09.10.2020</span>
                    <span class="divider-dash"><span class="text-warning">Подписание</span></span>
                  </small>
                </div>
              </a>

              <span class="lead text-fade">16 000 500₸</span>
            </div>



            <div class="media align-items-center">
              <label class="custom-control custom-checkbox pr-12">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-indicator"></span>
              </label>

              <a class="flexbox align-items-center flex-grow gap-items text-truncate" href="#qv-user-details" data-toggle="quickview">
                <img class="avatar" src="assets/img/avatar/3.jpg" alt="...">

                <div class="media-body text-truncate">
                  <h6>Тендер на услуги</h6>
                  <small>
                    <span>#98654</span>
                    <span class="divider-dash">09.10.2020</span>
                    <span class="divider-dash"><span class="text-success">Закончился</span></span>
                  </small>
                </div>
              </a>

              <span class="lead text-fade">664 006₸</span>
            </div>




            <div class="media align-items-center">
              <label class="custom-control custom-checkbox pr-12">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-indicator"></span>
              </label>

              <a class="flexbox align-items-center flex-grow gap-items text-truncate" href="#qv-user-details" data-toggle="quickview">
                <img class="avatar" src="assets/img/avatar/4.jpg" alt="...">

                <div class="media-body text-truncate">
                  <h6>Тендер на закупки</h6>
                  <small>
                    <span>#46358</span>
                    <span class="divider-dash">10.10.2020</span>
                    <span class="divider-dash"><span class="text-danger">Сбор заявок</span></span>
                  </small>
                </div>
              </a>

              <span class="lead text-fade">60 090₸</span>
            </div>




            <div class="media align-items-center">
              <label class="custom-control custom-checkbox pr-12">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-indicator"></span>
              </label>

              <a class="flexbox align-items-center flex-grow gap-items text-truncate" href="#qv-user-details" data-toggle="quickview">
                <img class="avatar" src="assets/img/avatar/default.jpg" alt="...">

                <div class="media-body text-truncate">
                  <h6>Тендер на обслуживание</h6>
                  <small>
                    <span>#54882</span>
                    <span class="divider-dash">11.10.2020</span>
                    <span class="divider-dash"><span class="text-success">Закончился</span></span>
                  </small>
                </div>
              </a>

              <span class="lead text-fade">99 900₸</span>
            </div>





            <div class="media align-items-center">
              <label class="custom-control custom-checkbox pr-12">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-indicator"></span>
              </label>

              <a class="flexbox align-items-center flex-grow gap-items text-truncate" href="#qv-user-details" data-toggle="quickview">
                <img class="avatar" src="assets/img/avatar/5.jpg" alt="...">

                <div class="media-body text-truncate">
                  <h6>Тендер на закупки</h6>
                  <small>
                    <span>#87634</span>
                    <span class="divider-dash">12.10.2020</span>
                    <span class="divider-dash"><span class="text-success">Закончился</span></span>
                  </small>
                </div>
              </a>

              <span class="lead text-fade">500 000₸</span>
            </div>

          </div>


          <footer class="flexbox align-items-center py-20">
            <span class="flex-grow text-right text-lighter pr-2">Показано 1-10 из 1,853</span>
            <nav>
              <a class="btn btn-sm btn-square disabled" href="#"><i class="ti-angle-left"></i></a>
              <a class="btn btn-sm btn-square" href="#"><i class="ti-angle-right"></i></a>
            </nav>
          </footer>

        </div>


      </div><!--/.main-content -->


      <!-- Footer -->
      <footer class="site-footer">
        <div class="row">
          <div class="col-md-6">
            <p class="text-center text-md-left">Copyright © 2020. All rights reserved.</p>
          </div>

          <div class="col-md-6">
            <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
            </ul>
          </div>
        </div>
      </footer>
      <!-- END Footer -->

    </main>
    <!-- END Main container -->





    <div class="fab fab-fixed">
      <a class="btn btn-float btn-primary" href="#qv-invoice-add" title="New Invoice" data-provide="tooltip" data-toggle="quickview"><i class="ti-plus"></i></a>
    </div>




    <!-- Quickview - Add invoice -->
    <div id="qv-invoice-add" class="quickview quickview-lg">
      <header class="quickview-header">
        <p class="quickview-title lead fw-400">Create new invoice</p>
        <span class="close"><i class="ti-close"></i></span>
      </header>

      <div class="quickview-body">

        <div class="quickview-block form-type-material">

          <h6>Details</h6>
          <div class="form-group">
            <input type="text" class="form-control">
            <label>Client</label>
          </div>

          <div class="form-group">
            <input type="text" class="form-control">
            <label>Invoice Number</label>
          </div>

          <div class="form-group">
            <input type="text" class="form-control" data-provide="datepicker">
            <label>Invoice Date</label>
          </div>

          <div class="form-group">
            <input type="text" class="form-control" data-provide="datepicker">
            <label>Due Date</label>
          </div>

          <div class="form-group input-group">
            <div class="input-group-input">
              <input type="text" class="form-control">
              <label>Discount</label>
            </div>
            <select data-provide="selectpicker">
              <option>Percent</option>
              <option>Amount</option>
            </select>
          </div>

          <div class="form-group">
            <textarea class="form-control" rows="3"></textarea>
            <label>Note to client</label>
          </div>

          <div class="h-40px"></div>

          <h6>Products</h6>

          <div class="form-group input-group align-items-center">
            <select title="Item" data-provide="selectpicker" data-width="100%">
              <option>Website design</option>
              <option>PSD to HTML</option>
              <option>Website re-design</option>
              <option>UI Kit</option>
              <option>Full Package</option>
            </select>
            <div class="input-group-input">
              <input type="text" class="form-control">
              <label>Quantity</label>
            </div>

            <a class="text-danger pl-12" id="btn-remove-item" href="#" title="Remove" data-provide="tooltip"><i class="ti-close"></i></a>
          </div>

          <a class="btn btn-sm btn-primary" id="btn-new-item" href="#"><i class="ti-plus fs-10"></i> New item</a>

        </div>
      </div>

      <footer class="p-12 text-right">
        <button class="btn btn-flat btn-secondary" type="button" data-toggle="quickview">Cancel</button>
        <button class="btn btn-flat btn-primary" type="submit">Create invoice</button>
      </footer>
    </div>
    <!-- END Quickview - Add user -->




    <!-- Quickview - User detail -->
    <div id="qv-user-details" class="quickview quickview-lg">
      <header class="quickview-header">
        <p class="quickview-title lead fw-400">Change invoice</p>
        <span class="close"><i class="ti-close"></i></span>
      </header>

      <div class="quickview-body">

        <div class="quickview-block form-type-material">

          <h6>Details</h6>
          <div class="form-group">
            <input type="text" class="form-control" value="Hossein Shams">
            <label>Client</label>
          </div>

          <div class="form-group">
            <input type="text" class="form-control" value="68531">
            <label>Invoice Number</label>
          </div>

          <div class="form-group">
            <input type="text" class="form-control" value="03/03/2017" data-provide="datepicker">
            <label>Invoice Date</label>
          </div>

          <div class="form-group">
            <input type="text" class="form-control" value="02/28/2017" data-provide="datepicker">
            <label>Due Date</label>
          </div>

          <div class="form-group input-group">
            <div class="input-group-input">
              <input type="text" class="form-control" value="0">
              <label>Discount</label>
            </div>
            <select data-provide="selectpicker">
              <option>Percent</option>
              <option>Amount</option>
            </select>
          </div>

          <div class="form-group">
            <textarea class="form-control" rows="3"></textarea>
            <label>Note to client</label>
          </div>

          <div class="h-40px"></div>

          <h6>Products</h6>

          <div class="form-group input-group align-items-center">
            <select title="Item" data-provide="selectpicker" data-width="100%">
              <option>Website design</option>
              <option>PSD to HTML</option>
              <option selected>Website re-design</option>
              <option>UI Kit</option>
              <option>Full Package</option>
            </select>
            <div class="input-group-input">
              <input type="text" class="form-control" value="1">
              <label>Quantity</label>
            </div>

            <a class="text-danger pl-12" id="btn-remove-item" href="#" title="Remove" data-provide="tooltip"><i class="ti-close"></i></a>
          </div>

          <div class="form-group input-group align-items-center">
            <select title="Item" data-provide="selectpicker" data-width="100%">
              <option>Website design</option>
              <option>PSD to HTML</option>
              <option>Website re-design</option>
              <option selected>UI Kit</option>
              <option>Full Package</option>
            </select>
            <div class="input-group-input">
              <input type="text" class="form-control" value="1">
              <label>Quantity</label>
            </div>

            <a class="text-danger pl-12" id="btn-remove-item" href="#" title="Remove" data-provide="tooltip"><i class="ti-close"></i></a>
          </div>

          <a class="btn btn-sm btn-primary" id="btn-new-item" href="#"><i class="ti-plus fs-10"></i> New item</a>

        </div>
      </div>

      <footer class="p-12 flexbox flex-justified">
        <button class="btn btn-flat btn-secondary" type="button" data-toggle="quickview">Cancel</button>
        <a class="btn btn-flat btn-danger">Delete</a>
        <button class="btn btn-flat btn-primary" type="submit">Save changes</button>
      </footer>
    </div>
    <!-- END Quickview - User detail -->



    <!-- Scripts -->
    <script src="../../assets/js/core.min.js"></script>
    <script src="../../assets/js/app.min.js"></script>
    <script src="assets/js/script.js"></script>


  </body>
</html>
