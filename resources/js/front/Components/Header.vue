<template>
    <div id="wrapper">
           
            <header id="header">
                <div class="top-header d-lg-block">
                    <div class="container-xl container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <ul class="top-address">
                                    
                                    <li>
                                        <i class="fa fa-envelope"></i>
                                        mr.linh1090@gmail.com
                                    </li>
                                
                                
                                    <li>
                                        <i class="fa fa-phone"></i>
                                        0968146460
                                    </li>
                                    
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="top-right-menu text-end">
                                    <li>
                                        <span class="welcome-message">
                                            welcome to our store!
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-xl container-fluid">
                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 col-sm-12 align-self-center">
                            <div class="logo">
                                <a href="">
                                    <img
                                        src=""
                                        alt=""
                                    />
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-8 col-sm-12">
                            <div class="searchbox position-relative my-3">
                                <form
                                    method="GET"
                                    class="search-form rounded-0 d-flex"
                                >
                                    <input
                                        type="text"
                                        class="form-control rounded-0"
                                        id="search"
                                        name="keyword"
                                        value=""
                                        placeholder="Search Product Here..."
                                    />
                                    <select
                                        class="form-select search-categories"
                                        value=""
                                        name="category"
                                        aria-label="Default select example"
                                    >
                                            <option value="all">
                                                All Categories
                                            </option>
                                    </select>
                                    <button
                                        type="submit"
                                        class="btn btn-primary rounded-0"
                                    >
                                        <i class="fa fa-search"></i>
                                    </button>
                                </form>
                                <div class="search-content position-absolute"></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <ul class="header-as ml-auto mr-0 text-lg-right text-center">
                            
                                    <li>
                                        <div class="dropdown">
                                            <a
                                                href="#"
                                                class="dropdown-toggle"
                                                id="dropdownMenuButton"
                                                data-toggle="dropdown"
                                            >
                                                <i class="far fa-user"></i>
                                                Hello,
                                                {userSession.user_name.substring(
                                                    0,
                                                    10
                                                ) + "..."}
                                            </a>
                                            <div
                                                class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton"
                                            >
                                                <a
                                                    class="dropdown-item"
                                                    href=""
                                                >
                                                    My Profile
                                                </a>
                                                <a
                                                    class="dropdown-item"
                                                    href=""
                                                >
                                                    My Cart
                                                </a>
                                                <a
                                                    class="dropdown-item"
                                                    href=""
                                                >
                                                    My Orders
                                                </a>
                                                <a
                                                    class="dropdown-item"
                                                    href=""
                                                >
                                                    My Reviews
                                                </a>
                                                <a
                                                    class="dropdown-item"
                                                    href=""
                                                >
                                                    Change Password
                                                </a>
                                                <a
                                                    class="dropdown-item"
                                                    href=""
                                                >
                                                    Log Out
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                               
                                    
                                        <li>
                                            <a
                                                href=""
                                            >
                                                <i class="far fa-user"></i>
                                                My Account
                                            </a>
                                        </li>
                                   
                           
                                <li>
                                    <a href="">
                                        <i class="far fa-heart"></i>
                                        Wishlist
                                    </a>
                                    <span class="wishlist-count">
                                        5
                                    </span>
                                </li>
                                <li>
                                    <a href="">
                                        <i class="fas fa-shopping-cart"></i>
                                        Cart
                                    </a>
                                    <span class="cartlist">{userCart}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            <nav class="navbar navbar-expand-lg">
                <div class="container-xl container-fluid">
                    <div class="navbar-brand" href="#">
                        <div class="nav-item dropdown">
                            <a
                                class="nav-a dropdown-toggle"
                                href="#"
                                id="navbarDropdownMenua"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                shopping by Categories
                            </a>
                            <ul
                                class="dropdown-menu"
                                aria-labelledby="navbarDropdownMenua"
                            >
                                
                                        <li key={cat_menu.id}>
                                            <a
                                                class="dropdown-item"
                                                href=""
                                            >
                                            category_name
                                            </a>
                                        </li>
                                            
                            </ul>
                        </div>
                    </div>
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown"
                        aria-controls="navbarNavDropdown"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div
                        class="collapse navbar-collapse"
                        id="navbarNavDropdown"
                    >
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a
                                    class="nav-a active"
                                    aria-current="page"
                                    href=""
                                >
                                    Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-a active"
                                    aria-current="page"
                                    href=""
                                >
                                    Shop
                                </a>
                            </li>
                                        <li
                                            class="nav-item"
                                            key={page.page_id}
                                        >
                                            <a
                                                href=""
                                                class="nav-a active"
                                                aria-current="page"
                                            >
                                            page_title
                                            </a>
                                        </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
</template>