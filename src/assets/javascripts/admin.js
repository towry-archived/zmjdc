(function () {
    z.Admin = function () {
        function e() {
            this.$allow = $(".js-allow"), this.$notallow = $(".js-notallow");
        }

        return e.prototype.addHandlers = function () {
            var that = this;
            this.$allow.on('click', function (e) {
                e.preventDefault();

                var q = z.util.objectQuery($(this).attr('href'));

                $.extend(q, {nuid: Cookies.get('nuid_'), suid: Cookies.get('suid_')});

                $.ajax('/api/memory/allow', {
                    type: 'GET',
                    async: true,
                    data: q, 
                    complete: function (d, s) {
                        if (s !== "success") {
                            z.message('error', 'Request failed');
                        }

                        var dataCell = $(".data-" + q.m);
                        dataCell.fadeOut('slow');
                    }
                });
            });

            this.$notallow.on('click', function (e) {
                e.preventDefault();

                var q = z.util.objectQuery($(this).attr('href'));

                $.extend(q, {nuid: Cookies.get('nuid_'), suid: Cookies.get('suid_')});

                $.ajax('/api/memory/notallow', {
                    type: 'GET',
                    async: true,
                    data: q, 
                    complete: function (d, s) {
                        if (s !== "success") {
                            z.message('error', 'Request failed');
                        }

                        var dataCell = $(".data-" + q.m);
                        dataCell.fadeOut('slow');
                    }
                });
            });
        }, e;
    }(), $(function () {
        return z.admin = new z.Admin(), z.admin.addHandlers();
    });
})();
