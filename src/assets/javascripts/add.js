(function () {
    z.Add = function () {
        function e() {
        }
        return e.prototype.strictWord = function (e) {
            var $that = $(e);
            return $that.on('keyup', function (e) {
                var val = $(this).val();
                if (! val) return !0;
                if (! val.match(/^(?:\s*)[a-zA-Z]+\s*$/)) {
                    val = val.slice(0, val.length - 1);
                    $that.val(val);

                    return !1;
            };
            return !0;
        }) 
    },
    }(), $(function () {
    })
}).call(this);
