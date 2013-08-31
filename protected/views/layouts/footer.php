<div class="footer_inner">

    <div class="footer_contacts">
        <div class="copyright">
            © 2012 - 2013. TWT Consult<br>
            Горячая линия +7 (495) 660-81-11<br>
        </div>
        <div class="counters">
            <!-- Yandex.Metrika counter -->
            <script type="text/javascript">
                (function (d, w, c) {
                    (w[c] = w[c] || []).push(function () {
                        try {
                            w.yaCounter19010836 = new Ya.Metrika({id: 19010836,
                                webvisor: true,
                                clickmap: true,
                                trackLinks: true,
                                accurateTrackBounce: true});
                        } catch (e) {
                        }
                    });

                    var n = d.getElementsByTagName("script")[0],
                        s = d.createElement("script"),
                        f = function () {
                            n.parentNode.insertBefore(s, n);
                        };
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                    if (w.opera == "[object Opera]") {
                        d.addEventListener("DOMContentLoaded", f, false);
                    } else {
                        f();
                    }
                })(document, window, "yandex_metrika_callbacks");
            </script>
            <noscript>
                <div><img src="//mc.yandex.ru/watch/19010836" style="position:absolute; left:-9999px;" alt=""/>
                </div>
            </noscript>
            <!-- /Yandex.Metrika counter -->
            <script type="text/javascript">

                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-37247170-1']);
                _gaq.push(['_trackPageview']);

                (function () {
                    var ga = document.createElement('script');
                    ga.type = 'text/javascript';
                    ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(ga, s);
                })();

            </script>
        </div>
        <div class="search">
            <form action="/search" method="get" id="search_form">
                <label class="infield" style="display: block; ">поиск по сайту</label>
                <input type="text" name="q">
                <input type="image" src="<?= $this->baseAssets.'/img/search.png'; ?>" alt="search" title="search">
            </form>
            <div class="search_sample" id="search_sample">
                Например: <span>страхование груза</span>
            </div>
        </div>
        <div class="our_logo">
            <div>
                <a href="http://artektiv.ru/" target="_blank">Разработка сайта</a>
            </div>
            <a href="http://artektiv.ru/" target="_blank"><img alt="" title="" src="<?= $this->baseAssets.'/img/art_logo.png'; ?>"></a>

        </div>

    </div>
</div>