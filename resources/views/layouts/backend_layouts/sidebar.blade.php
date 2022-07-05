<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('images/backend_user/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/storage/images/userprofile/{{Auth::guard('admin')->user()->Profile}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::guard('admin')->user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
                @if(Session::get('page')=='dashboard')
                    <?php $active ="active"; ?>
                @else
                    <?php $active = ""; ?>
                @endif
                <a href="/admin/dashboard" class="nav-link {{$active}}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        {{__('Dashboard')}}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                @if(Session::get('page')=='usermanagement')
                    <?php $active ="active"; ?>
                @else
                    <?php $active = ""; ?>
                @endif
                <a href="/admin/usermangement" class="nav-link {{$active}}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        {{__('User Management')}}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                @if(Session::get('page')=='subscription')
                    <?php $active ="active"; ?>
                @else
                    <?php $active = ""; ?>
                @endif
                <a href="/admin/subscription" class="nav-link {{$active}}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        {{__('Subscription')}}
                    </p>
                </a>
            </li>

          <li class="nav-item">
            @if(Session::get('page')=='setting')
            <?php $active ="active"; ?>
        @else
            <?php $active = ""; ?>
        @endif
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                My Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="/admin/settings" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
            </ul>


            <li class="nav-item">
                @if(Session::get('page')=='section' || Session::get('page')=='category' || Session::get('page')=='product' || Session::get('page')=='order')
                <?php $active ="active"; ?>
                @else
                 <?php $active = ""; ?>
                @endif
                <a href="#" class="nav-link {{$active}}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>

                  <p>
                        Catalogues
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    @if(Session::get('page')=='section')
                <?php $active ="active"; ?>
                @else
                 <?php $active = ""; ?>
                @endif
                    <li class="nav-item">
                    <a href="/admin/section" class="nav-link {{$active}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Section</p>
                    </a>
                  </li>
                  @if(Session::get('page')=='category')
                  <?php $active ="active"; ?>
                  @else
                   <?php $active = ""; ?>
                  @endif
                      <li class="nav-item">
                      <a href="/admin/categories" class="nav-link {{$active}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Categories</p>
                      </a>
                    </li>
                    @if(Session::get('page')=='product')
                    <?php $active ="active"; ?>
                    @else
                     <?php $active = ""; ?>
                    @endif
                        <li class="nav-item">
                        <a href="/admin/products" class="nav-link {{$active}}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Products</p>
                        </a>
                      </li>
                      @if(Session::get('page')=='order')
                      <?php $active ="active"; ?>
                      @else
                       <?php $active = ""; ?>
                      @endif
                          <li class="nav-item">
                          <a href="/admin/orders" class="nav-link {{$active}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Orders</p>
                          </a>
                        </li>
                        @if(Session::get('page')=='subscribe')
                      <?php $active ="active"; ?>
                      @else
                       <?php $active = ""; ?>
                      @endif
                          <li class="nav-item">
                          <a href="/admin/subscribeemail" class="nav-link {{$active}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Newsletter Subscription</p>
                          </a>
                        </li>
                        @if(Session::get('page')=='rating')
                        <?php $active ="active"; ?>
                        @else
                         <?php $active = ""; ?>
                        @endif
                            <li class="nav-item">
                            <a href="/admin/rating" class="nav-link {{$active}}">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Ratings</p>
                            </a>
                          </li>

                          @if(Session::get('page')=='returnorder')
                          <?php $active ="active"; ?>
                          @else
                           <?php $active = ""; ?>
                          @endif
                              <li class="nav-item">
                              <a href="/admin/returnrequest" class="nav-link {{$active}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Return Request</p>
                              </a>
                            </li>

                            @if(Session::get('page')=='exchangeorder')
                            <?php $active ="active"; ?>
                            @else
                             <?php $active = ""; ?>
                            @endif
                                <li class="nav-item">
                                <a href="/admin/exchagerequest" class="nav-link {{$active}}">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Exchage Request</p>
                                </a>
                              </li>
                </ul>
                <li class="nav-item">
                    @if(Session::get('page')=='cms' )
                    <?php $active ="active"; ?>
                    @else
                     <?php $active = ""; ?>
                    @endif
                    <a href="/admin/cmsmanagement" class="nav-link {{$active}}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                        CMS Management
                        </p>
                    </a>
                </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
</aside>
