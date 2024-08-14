<template>
    <div className="footer-widget">
            <div className="container-xl container-fluid">
                <div className="row">
                    <div className="col-lg-3 col-md-6 mb-5">
                        <div className="site-info-widget">
                            <div className="footer-logo">
                                <a href="">
                                    <h6>generalSettings.site_name</h6>
                                </a>
                            </div>
                            <p>dangerouslySetInnerHTML</p>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div className="footer-bottom py-3">
                <div className="container">
                    <div className="row">
                        <div className="col-md-6 col-12 align-self-center">
                            <input
                                type="hidden"
                                className="demo"
                                value=""
                            ></input>
                            <span>
                                {" "}
                                <strong>
                                    {generalSettings.copyright} by{" "}
                                    <a target="_blank" href="https://news-portal.shop/">
                                        Linh Dev
                                    </a>
                                    .
                                </strong>{" "}
                                All rights reserved
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>