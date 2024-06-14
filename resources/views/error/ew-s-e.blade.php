<script>
    $(".question-response-rows").click(function() {
        var e = $(this).data("question"),
            n = ".question-" + e;
        $(".question").addClass("hidden"), $(n).removeClass("hidden"), $("input[name=currentQuestionNumber]")
            .val(e), $("#current-question-number-label").text(e), $("#back-to-prev-question").removeClass(
                "disabled"), $("#go-to-next-question").removeClass("disabled")
    });
    var examWizard = $.fn.examWizard({
        finishOption: {
            enableModal: !0
        }
    });
    @if ($waktu_ujian->selesai == null)
        var countDownDate = new Date("{{ $waktu_ujian->waktu_berakhir }}").getTime(),
            x = setInterval(function() {
                var a = (new Date).getTime(),
                    e = countDownDate - a,
                    n = (Math.floor(e / 864e5), Math.floor(e % 864e5 / 36e5)),
                    t = Math.floor(e % 36e5 / 6e4),
                    a = Math.floor(e % 6e4 / 1e3);
                document.querySelector(".jam_skrng").innerHTML = n + " : " + t + " : " + a, e < 0 && (clearInterval(
                        x), document.querySelector(".jam_skrng").innerHTML = "00 : 00 : 00", $(".timer-check")
                    .removeClass("hidden"), $(".ragu-container").addClass("hidden"))
            }, 500);
        $("textarea").change(function() {
            var a = "soalId" + $(this).attr("name");
            $("#" + a).removeClass("btn-white"), $("#" + a).addClass("btn-info"), $("#" + a).addClass(
                "text-white");
            var e = $(this).attr("name"),
                n = $(this).data("essay_siswa"),
                a = $(this).val();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                type: "POST",
                data: {
                    idDetail: e,
                    id_essay: n,
                    jawaban: a,
                    _token: "{{ csrf_token() }}"
                },
                async: !0,
                url: "{{ url('/siswa/simpan_essay') }}",
                success: function(a) {
                    console.log(a)
                }
            })
        }), $(".ragu").click(function() {
            var a, e = "soalId" + $(this).data("mark_name");
            $(this).is(":checked") ? ($("#" + e).removeClass("btn-white"), $("#" + e).addClass("btn-warning"),
                a = $(this).data("id_essay"), $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    type: "POST",
                    data: {
                        ragu: 1,
                        id_essay: a,
                        _token: "{{ csrf_token() }}"
                    },
                    async: !0,
                    url: "{{ url('/siswa/ragu_essay') }}",
                    success: function(a) {
                        console.log(a)
                    }
                })) : ($("#" + e).removeClass("btn-warning"), $("#" + e).hasClass("btn-info") ? $("#" + e)
                .removeClass("btn-white") : $("#" + e).addClass("btn-white"), a = $(this).data("id_essay"),
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    type: "POST",
                    data: {
                        ragu: null,
                        id_essay: a,
                        _token: "{{ csrf_token() }}"
                    },
                    async: !0,
                    url: "{{ url('/siswa/ragu_essay') }}",
                    success: function(a) {
                        console.log(a)
                    }
                }))
        }), $("#go-to-next-question").click(function() {
            var a = $("input[name=currentQuestionNumber]").val(),
                e = parseInt(a) + parseInt(1),
                a = "ragus-" + e;
            e <= "{{ $ujian->detailessay->count() }}" && ($(".ragus").addClass("hidden"), $("." + a)
                .removeClass("hidden"))
        }), $("#back-to-prev-question").click(function() {
            var a = $("input[name=currentQuestionNumber]").val(),
                e = parseInt(a) - parseInt(1),
                a = "ragus-" + e;
            0 != e && ($(".ragus").addClass("hidden"), $("." + a).removeClass("hidden"))
        }), $(".kirim-jawaban").on("click", function(a) {
            a.preventDefault(), swal({
                title: "apakah kamu yakin?",
                text: "pastikan anda sudah menjawab soal dengan benar!",
                type: "warning",
                showCancelButton: !0,
                cancelButtonText: "tidak",
                confirmButtonText: "ya, kirim",
                padding: "2em"
            }).then(function(a) {
                a.value && $("#examwizard-question").submit()
            })
        });
    @endif
</script>
