(function () {
    z.Words = (function () {
        function e() {}

        return e.prototype.handleVotes = function (e, b) {
            var $ele = $(b), q, $parent = $(e.delegateTarget);

            e.preventDefault();

            if (!z.user.isauth()) {
                z.message('error', z.i18n.text('need_auth'));

                return false;
            }

            q = z.util.objectQuery($ele.attr('href'));

            $.extend(q, {type: 'all', nuid: Cookies.get('nuid_'), suid: Cookies.get('suid_')});

            $.ajax('/api/rate', {
                type: 'GET',
                data: q,
                async: false,
                complete: function (d, s) {
                    console.log(d);
                    if (s !== "success") {
                        // something wrong
                        z.message('error', 'something wrong, try again');

                        return false;
                    }

                    var _d = JSON.parse(d.responseText), _c, _e;

                    if (_d.error_code) {
                        z.message('error', _d.error_msg);

                        return false;
                    }

                    _c = _d.response_body - 0;
                    _e = q.a - 0;

                    if (_e === 1) {
                        // upvote
                        if (_c === -1) {
                            var $count = $('.count', $ele), count;
                            
                            $parent.removeClass('voted-up');
                            count = $count.text() - 0;
                            count -= 1;
                            
                            if (count < 0) return;
                            
                            return $count.text(count);
                        } else if (_c === 1) {
                            var $count = $('.count', $ele), count;
                            $parent.removeClass('voted-down').addClass('voted-up');
                            count = $count.text() - 0;
                            count += 1;
                            
                            return $count.text(count);
                        }
                    } else if (_e === -1) {
                        // downvote
                        if (_c === -1 ) {
                            $parent.removeClass('voted-down');
                        } else if (_c === 1) {
                            $parent.removeClass('voted-up').addClass('voted-down');
                        } 
                        return;
                    }

                }
            })

        }, e;
    }).call(this), $(function () {
        return z.words = new z.Words(), $(".votes").on('click', '.vote-anchor', function (e) {
            return z.words.handleVotes(e, this);
        })
    })
}).call(this);
