<div class="app-header white box-shadow">
    <div class="navbar">
        <!-- Open side - Naviation on mobile -->
        <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up" id="open-nav">
          <i class="material-icons">&#xe5d2;</i>
        </a>
        <!-- / -->
        <div class="col-sm-6">
            <h4 class="m-b-0 m-t-xs _300">{welcome_message}</h4>
            <small class="text-muted">{app_description}</small>
        </div>

        <!-- navbar collapse -->
        <div class="collapse navbar-toggleable-sm" id="collapse">
          <div ui-include="'../views/blocks/navbar.form.right.html'"></div>
        </div>
        <!-- / navbar collapse -->
    </div>
</div>
