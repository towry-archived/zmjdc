/* vim: set expandtab sw=4 ts=4 sts=4: */
(function () {
    z.Home = function () {
        function e() {
            this.listenSearch('#s'), this.$menuItems = $("#menu-items");
        }

        return e.prototype.listenSearch = function (e) {
            var that = this,
                $that = $(e);
            return $that.on('keyup', function (e) {
                var val = $that.val();
                if (! val) return !0;
                if (! val.match(/^(?:\s*)[a-zA-Z]+\s*$/)) {
                    val = val.slice(0, val.length - 1);
                    $that.val(val);

                    return !1;
                }
                return !0;
            }), $that.closest('form').on('submit', function (e) {
                var val = $that.val().trim();

                if (val === "") return false;

                try {
                    var n = 'dc', dc = localStorage.getItem('dc');
                    dc ? localStorage.setItem(n, dc += (","+val)) : localStorage.setItem(n, val);
                } catch(e) {}
            });
        }, e.prototype.autoComplete = function (val) {
            var that = this,
                d = null;
            try {
                var n = 'dc';
                d = localStorage.getItem(n);
            } catch(e) {}

            if (d) {
                var b = d.split(',');

                return b.forEach(function (i, l) {
                    if (i.indexOf(val) === 0) return !0;
                });
            } else {
                // get the testcase from server

            }
            return [];
        }, e.prototype.resize = function () {
            var that = this;
            return function () {
                $(window).width() > 600 && that.$menuItems.removeClass('visible');              }
        },e;
        
    }(), $(function () {
        z.home = new z.Home(), z.home._r = z.util.throttle(z.home.resize()), $(window).resize(z.home._r);
    });
}).call(this);
