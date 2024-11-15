<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
        <div class="pcoded-inner-navbar main-menu">
            <ul class="pcoded-item pcoded-left-item">
                <li class="active">
                    <a href="{{route('admin.dashboard')}}">
                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">VENTE</div>
            <ul class="pcoded-item pcoded-left-item">
                <li>
                    <a href="{{route('admin.caisse')}}">
                        <span class="pcoded-micon"><i class="ti-shopping-cart"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Caisse</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('sales.index')}}">
                        <span class="pcoded-micon"><i class="ti-list"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Liste de vente</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="pcoded-micon"><i class="ti-file"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Proforma</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                
            </ul>

            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">GESTION PRODUITS</div>
            <ul class="pcoded-item pcoded-left-item">
                <li>
                    <a href="{{route('admin.produitVente')}}">
                        <span class="pcoded-micon"><i class="ti-shopping-cart-full"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Produit en vendre</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.ajoutercategory')}}">
                        <span class="pcoded-micon"><i class="ti-shopping-cart-full"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Catégories Produits</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.productingredient')}}">
                        <span class="pcoded-micon"><i class="ti-shopping-cart-full"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Menu produits</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('ingredients.create')}}">
                        <span class="pcoded-micon"><i class="ti-shopping-cart-full"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Ingredient</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('appro.create')}}">
                        <span class="pcoded-micon"><i class="ti-bookmark-alt"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Approvisionnement</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.stock')}}">
                        <span class="pcoded-micon"><i class="ti-notepad"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Inventaire</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li>
                    <a href="map-google.html">
                        <span class="pcoded-micon"><i class="ti-export"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Transfert</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li>
                    <a href="map-google.html">
                        <span class="pcoded-micon"><i class="ti-archive"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Dépôt</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                
            </ul>

            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.other">ETAT FINANCIERE</div>
            <ul class="pcoded-item pcoded-left-item">
                <li>
                    <a href="{{route('showExpenses')}}">
                        <span class="pcoded-micon"><i class="ti-money"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Dépense</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.etat')}}">
                        <span class="pcoded-micon"><i class="ti-stats-up"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Etat</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                
            </ul>

        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.other">Autres</div>
            <ul class="pcoded-item pcoded-left-item">
                <li>
                    <a href="{{route('supplier.create')}}">
                        <span class="pcoded-micon"><i class="ti-truck"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Fournisseurs</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li>
                    <a href="map-google.html">
                        <span class="pcoded-micon"><i class="ti-crown"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Clients</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li>
                    <a href="map-google.html">
                        <span class="pcoded-micon"><i class="ti-user"></i><b>FC</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Utilisateurs</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
        </div>
</nav>