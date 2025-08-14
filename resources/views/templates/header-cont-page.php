<?php
$currUser = userAllData();
$home_url = home_url();
$home_link = '/';
if ($data['mod'] == 'home') {
    $home_link = 'javascript:void(0)';
}
$link_lk = '/dashboard';
$link_lk_text = 'В личный кабинет';
if (is_admin_allowed()) {
    $link_lk = '/admin';
    $link_lk_text = 'В админку';
}
?>

<header id="topnav" class="defaultscroll sticky">
    <div class="container">
        <div class="header-container">
            <a class="logo" href="<?php echo $home_link;?>">
                <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" height="24" class="logo-light-mode" alt="">
                <img src="<?php echo $home_url;?>/public/images/favicon/android-chrome-512x512.png" height="24" class="logo-dark-mode" alt="">
                <div class="text-logo">
                    <span class="d-block fw-bolder">ВЕРНЫЙ МЕТОД</span>
                    <span class="d-block fs-6 fw-medium">юридическая помощь</span>
                    <span class="d-block fs-6 fw-medium">юристы И адвокаты</span>
                </div>
            </a>

            <div id="navigation">
                <ul class="navigation-menu">
                    <li><a href="/" class="sub-menu-item">Home</a></li>
                    <li class="has-submenu parent-parent-menu-item">
                        <a href="javascript:void(0)">Landing</a><span class="menu-arrow"></span>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li class="megamenu-head"><i class="uil uil-book-open fs-6 align-middle"></i> Landing Pages</li>
                                    <li><a href="index-saas.html" class="sub-menu-item">Saas</a></li>
                                    <li><a href="index-classic-saas.html" class="sub-menu-item">Classic Saas</a></li>
                                    <li><a href="index-modern-saas.html" class="sub-menu-item">Modern Saas <span class="badge text-bg-success ms-2">Animation</span></a></li>
                                    <li><a href="index-agency.html" class="sub-menu-item">Agency</a></li>
                                    <li><a href="index-apps.html" class="sub-menu-item">Application</a></li>
                                    <li><a href="index-classic-app.html" class="sub-menu-item">Classic App</a></li>
                                    <li><a href="index-modern-app.html" class="sub-menu-item">Modern App </a></li>
                                    <li><a href="index-studio.html" class="sub-menu-item">Studio</a></li>
                                    <li><a href="index-marketing.html" class="sub-menu-item">Marketing</a></li>
                                    <li><a href="index-enterprise.html" class="sub-menu-item">Enterprise</a></li>
                                    <li><a href="index-services.html" class="sub-menu-item">Service</a></li>
                                    <li><a href="index-payments.html" class="sub-menu-item">Payments</a></li>
                                    <li><a href="index-it-solution.html" class="sub-menu-item">IT Solution </a></li>
                                    <li><a href="index-it-solution-two.html" class="sub-menu-item">IT Solution Two </a></li>

                                </ul>
                            </li>

                            <li>
                                <ul>
                                    <li class="megamenu-head"><i class="uil uil-book-open fs-6 align-middle"></i> Landing Pages</li>
                                    <li><a href="index-developer.html" class="sub-menu-item">Developer</a></li>
                                    <li><a href="index-seo-agency.html" class="sub-menu-item">SEO Agency</a></li>
                                    <li><a href="index-hospital.html" class="sub-menu-item">Hospital</a></li>
                                    <li><a href="index-coworking.html" class="sub-menu-item">Coworking</a></li>
                                    <li><a href="index-business.html" class="sub-menu-item">Business</a></li>

                                    <li><a href="index-modern-business.html" class="sub-menu-item">Modern Business</a></li>
                                    <li><a href="index-finance.html" class="sub-menu-item">Finance </a></li>
                                    <li><a href="index-logistics.html" class="sub-menu-item">Delivery & Logistics </a></li>
                                    <li><a href="index-social-marketing.html" class="sub-menu-item">Social Media</a></li>
                                    <li><a href="index-digital-agency.html" class="sub-menu-item">Digital Agency</a></li>
                                    <li><a href="index-customer.html" class="sub-menu-item">Customer</a></li>
                                    <li><a href="index-software.html" class="sub-menu-item">Software</a></li>
                                    <li><a href="index-yoga.html" class="sub-menu-item">Yoga </a></li>
                                    <li><a href="index-gym.html" class="sub-menu-item">GYM & Fitness </a></li>

                                </ul>
                            </li>

                            <li>
                                <ul>
                                    <li class="megamenu-head"><i class="uil uil-book-open fs-6 align-middle"></i> Landing Pages</li>
                                    <li><a href="index-consulting.html" class="sub-menu-item">Consulting <span class="badge text-bg-danger ms-2">New</span></a></li>
                                    <li><a href="index-hotel.html" class="sub-menu-item">Hotel</a></li>
                                    <li><a href="index-restaurant.html" class="sub-menu-item">Restaurant </a></li>
                                    <li><a href="index-construction.html" class="sub-menu-item">Construction</a></li>
                                    <li><a href="index-videocall.html" class="sub-menu-item">Video Conference </a></li>
                                    <li><a href="index-blockchain.html" class="sub-menu-item">Blockchain </a></li>
                                    <li><a href="index-crypto-two.html" class="sub-menu-item">Cryptocurrency Two </a></li>
                                    <li><a href="index-integration.html" class="sub-menu-item">Integration</a></li>
                                    <li><a href="index-task-management.html" class="sub-menu-item">Task Management </a></li>
                                    <li><a href="index-email-inbox.html" class="sub-menu-item">Email Inbox </a></li>
                                    <li><a href="index-travel.html" class="sub-menu-item">Travel </a></li>
                                    <li><a href="index-course.html" class="sub-menu-item">Course</a></li>
                                    <li><a href="index-online-learning.html" class="sub-menu-item">Online Learning</a></li>
                                    <li><a href="index-insurance.html" class="sub-menu-item">Insurance</a></li>
                                    <li><a href="index-furniture.html" class="sub-menu-item">Furniture </a></li>

                                </ul>
                            </li>

                            <li>
                                <ul>
                                    <li class="megamenu-head"><i class="uil uil-book-open fs-6 align-middle"></i> Landing Pages</li>
                                    <li><a href="index-law-firm.html" class="sub-menu-item">Law Firm </a></li>
                                    <li><a href="index-single-product.html" class="sub-menu-item">Product</a></li>
                                    <li><a href="index-car-riding.html" class="sub-menu-item">Car Ride</a></li>
                                    <li><a href="index-landing-one.html" class="sub-menu-item">Landing One </a></li>
                                    <li><a href="index-landing-two.html" class="sub-menu-item">Landing Two </a></li>
                                    <li><a href="index-landing-three.html" class="sub-menu-item">Landing Three </a></li>
                                    <li><a href="index-landing-four.html" class="sub-menu-item">Landing Four</a></li>
                                    <li><a href="index-charity.html" class="sub-menu-item">Charity </a></li>
                                    <li><a href="index-personal.html" class="sub-menu-item">Personal</a></li>
                                    <li><a href="index-creative-personal.html" class="sub-menu-item">Creative Personal</a></li>

                                    <li><a href="index-freelancer.html" class="sub-menu-item">Freelance </a></li>
                                    <li><a href="index-event.html" class="sub-menu-item">Event</a></li>
                                    <li><a href="index-ebook.html" class="sub-menu-item">E-Book</a></li>
                                    <li><a href="index-onepage.html" class="sub-menu-item">Saas <span class="badge text-bg-warning ms-2">Onepage</span></a></li>

                                </ul>
                            </li>

                            <li>
                                <ul>
                                    <li class="megamenu-head"><i class="uil uil-cube fs-6 align-middle"></i> Full Demos</li>
                                    <li><a href="index-corporate.html" class="sub-menu-item">Corporate</a></li>
                                    <li><a href="index-crypto.html" class="sub-menu-item">Cryptocurrency <span class="badge text-bg-dark ms-2">Dark</span></a></li>
                                    <li><a href="index-shop.html" class="sub-menu-item">Shop</a></li>
                                    <li><a href="index-ai.html" class="sub-menu-item">AI Tools <span class="badge text-bg-danger ms-2">New</span></a></li>
                                    <li><a href="index-portfolio.html" class="sub-menu-item">Portfolio </a></li>
                                    <li><a href="helpcenter-overview.html" class="sub-menu-item">Help Center</a></li>
                                    <li><a href="index-hosting.html" class="sub-menu-item">Hosting & Domain</a></li>
                                    <li><a href="index-job.html" class="sub-menu-item">Jobs & Careers</a></li>
                                    <li><a href="index-video-studio.html" class="sub-menu-item">Video Studio </a></li>
                                    <li><a href="index-real-estate.html" class="sub-menu-item">Real Estate</a></li>
                                    <li><a href="forums.html" class="sub-menu-item">Forums</a></li>
                                    <li><a href="index-blog.html" class="sub-menu-item">Blog or News</a></li>
                                    <li><a href="index-nft.html" class="sub-menu-item">NFT Marketplace</a></li>
                                    <li><a href="index-photography.html" class="sub-menu-item">Photography <span class="badge text-bg-dark ms-2">Dark</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="has-submenu parent-parent-menu-item">
                        <a href="javascript:void(0)">Pages</a><span class="menu-arrow"></span>
                        <ul class="submenu">
                            <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Company </a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="page-aboutus.html" class="sub-menu-item"> About Us</a></li>
                                    <li><a href="page-aboutus-two.html" class="sub-menu-item"> About Us Two </a></li>
                                    <li><a href="page-services.html" class="sub-menu-item">Services</a></li>
                                    <li><a href="page-history.html" class="sub-menu-item">History </a></li>
                                    <li><a href="page-team.html" class="sub-menu-item"> Team</a></li>
                                    <li><a href="page-pricing.html" class="sub-menu-item">Pricing</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Account </a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="account-profile.html" class="sub-menu-item">Profile</a></li>
                                    <li><a href="account-members.html" class="sub-menu-item">Members </a></li>
                                    <li><a href="account-works.html" class="sub-menu-item">Works </a></li>
                                    <li><a href="account-messages.html" class="sub-menu-item">Messages </a></li>
                                    <li><a href="account-chat.html" class="sub-menu-item">Chat </a></li>
                                    <li><a href="account-payments.html" class="sub-menu-item">Payments </a></li>
                                    <li><a href="account-setting.html" class="sub-menu-item">Setting</a></li>
                                    <li><a href="page-invoice.html" class="sub-menu-item">Invoice</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Email Template</a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="email-confirmation.html" class="sub-menu-item">Confirmation</a></li>
                                    <li><a href="email-password-reset.html" class="sub-menu-item">Reset Password</a></li>
                                    <li><a href="email-alert.html" class="sub-menu-item">Alert</a></li>
                                    <li><a href="email-invoice.html" class="sub-menu-item">Invoice</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Blog </a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="blog-grid.html" class="sub-menu-item">Blog Grid</a></li>
                                    <li><a href="blog-grid-sidebar.html" class="sub-menu-item">Blog with Sidebar</a></li>
                                    <li><a href="blog-list.html" class="sub-menu-item">Blog Listing</a></li>
                                    <li><a href="blog-list-sidebar.html" class="sub-menu-item">Blog List & Sidebar</a></li>
                                    <li><a href="blog-detail.html" class="sub-menu-item">Blog Detail</a></li>
                                    <li><a href="blog-detail-two.html" class="sub-menu-item">Blog Detail 2 </a></li>
                                </ul>
                            </li>
                            <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Case Study </a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="page-cases.html" class="sub-menu-item">All Cases </a></li>
                                    <li><a href="page-case-detail.html" class="sub-menu-item">Case Detail </a></li>
                                </ul>
                            </li>
                            <li><a href="course-detail.html" class="sub-menu-item">Course Detail </a></li>
                            <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Auth Pages </a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li class="has-submenu child-menu-item"><a href="javascript:void(0)"> Login </a><span class="submenu-arrow"></span>
                                        <ul class="submenu">
                                            <li><a href="auth-login.html" class="sub-menu-item">Login</a></li>
                                            <li><a href="auth-cover-login.html" class="sub-menu-item">Login Cover</a></li>
                                            <li><a href="auth-login-three.html" class="sub-menu-item">Login Simple</a></li>
                                            <li><a href="auth-bs-login.html" class="sub-menu-item">BS5 Login</a></li>
                                            <li><a href="auth-login-bg-video.html" class="sub-menu-item">Login Five</a></li>
                                        </ul>
                                    </li>

                                    <li class="has-submenu child-menu-item"><a href="javascript:void(0)"> Signup </a><span class="submenu-arrow"></span>
                                        <ul class="submenu">
                                            <li><a href="auth-signup.html" class="sub-menu-item">Signup</a></li>
                                            <li><a href="auth-cover-signup.html" class="sub-menu-item">Signup Cover</a></li>
                                            <li><a href="auth-signup-three.html" class="sub-menu-item">Signup Simple</a></li>
                                            <li><a href="auth-bs-signup.html" class="sub-menu-item">BS5 Singup</a></li>
                                            <li><a href="auth-signup-bg-video.html" class="sub-menu-item">Singup Five</a></li>
                                        </ul>
                                    </li>

                                    <li class="has-submenu child-menu-item"><a href="javascript:void(0)"> Reset password </a><span class="submenu-arrow"></span>
                                        <ul class="submenu">
                                            <li><a href="auth-re-password.html" class="sub-menu-item">Reset Password</a></li>
                                            <li><a href="auth-cover-re-password.html" class="sub-menu-item">Reset Password Cover</a></li>
                                            <li><a href="auth-re-password-three.html" class="sub-menu-item">Reset Password Simple</a></li>
                                            <li><a href="auth-bs-reset.html" class="sub-menu-item">BS5 Reset Password</a></li>
                                            <li><a href="auth-reset-password-bg-video.html" class="sub-menu-item">Reset Pass Five</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Utility </a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="page-terms.html" class="sub-menu-item">Terms of Services</a></li>
                                    <li><a href="page-privacy.html" class="sub-menu-item">Privacy Policy</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Special</a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="page-comingsoon.html" class="sub-menu-item">Coming Soon</a></li>
                                    <li><a href="page-comingsoon2.html" class="sub-menu-item">Coming Soon Two</a></li>
                                    <li><a href="page-maintenance.html" class="sub-menu-item">Maintenance</a></li>
                                    <li><a href="page-error.html" class="sub-menu-item">Error</a></li>
                                    <li><a href="page-thankyou.html" class="sub-menu-item">Thank you</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Contact </a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="page-contact-detail.html" class="sub-menu-item">Contact Detail</a></li>
                                    <li><a href="page-contact-one.html" class="sub-menu-item">Contact One</a></li>
                                    <li><a href="page-contact-two.html" class="sub-menu-item">Contact Two</a></li>
                                    <li><a href="page-contact-three.html" class="sub-menu-item">Contact Three</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Multi Level Menu</a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="javascript:void(0)" class="sub-menu-item">Level 1.0</a></li>
                                    <li class="has-submenu child-menu-item"><a href="javascript:void(0)"> Level 2.0 </a><span class="submenu-arrow"></span>
                                        <ul class="submenu">
                                            <li><a href="javascript:void(0)" class="sub-menu-item">Level 2.1</a></li>
                                            <li><a href="javascript:void(0)" class="sub-menu-item">Level 2.2</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="footer.html" class="sub-menu-item">Footer Layouts </a></li>
                        </ul>
                    </li>

                </ul>
            </div>

            <div class="menu-extras">
                <div class="menu-item">
                    <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                </div>
            </div>
            <ul class="buy-button list-inline mb-0">
                <li class="list-inline-item mb-0">
                    <div class="btn-group dropdown-center">
                        <a href="javascript:void(0)" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="btn btn-icon btn-pills btn-soft-primary">
                                <i data-feather="user" class="fea icon-sm"></i>
                            </div>
                        </a>
                        <div class="dropdown-menu mt-2">
                            <?php if (is_login()) { ?>
                                <a class="dropdown-item d-flex align-items-center text-dark pb-3" href="/dashboard/">
                                    <img src="<?php echo $home_url;?>/public/assets/images/no-avatar.png" class="avatar avatar-md-sm rounded-circle border shadow" alt="">
                                    <div class="flex-1 ms-2">
                                        <span class="d-block"><?php echo ($currUser['first_name'])? $currUser['first_name'] : $currUser['username'];?></span>
                                        <small class="text-muted"><?php echo rolesMaskTranslate($currUser['roles_mask']);?></small>
                                    </div>
                                </a>
                                <a href="<?php echo $link_lk;?>" class="dropdown-item"><i data-feather="user" class="fea icon-sm"></i> <?php echo $link_lk_text;?></a>
                                <form action="/logout" method="post" accept-charset="utf-8" class="dropdown-item">
                                    <input type="hidden" name="actions" value="logOut">
                                    <button type="submit" class="dropdown-item dashboard-logout-btn"><i data-feather="log-out" class="fea icon-sm"></i> Выйти</button>
                                </form>
                            <?php } else { ?>
                                <a href="/login/" class="dropdown-item">Авторизация</a>
                                <a href="/signin/" class="dropdown-item">Регистрация</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</header>

<div class="header-fixed-height"></div>
