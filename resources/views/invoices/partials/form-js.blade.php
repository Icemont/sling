<script>
    document.addEventListener("DOMContentLoaded", function () {
        var previousButton = `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>`;
        var nextButton = `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg>`;

        window.Litepicker &&
        (new Litepicker({
            element: document.getElementById('invoice_date'),
            buttonText: {
                previousMonth: previousButton,
                nextMonth: nextButton,
            },
        })) &&
        (new Litepicker({
            element: document.getElementById('payment_date'),
            buttonText: {
                previousMonth: previousButton,
                nextMonth: nextButton,
            },
        }));
    });
    $(document).ready(function () {
        if ($('#is_paid').is(':checked')) {
            $("#paid-form").removeClass('d-none');
        }
        if ($('#currency').val() != {{ $currency_id ?? '1' }}) {
            $("#exchange-rate").removeClass('d-none');
        }
        $('#is_paid').click(function () {
            if ($(this).is(':checked')) {
                $("#paid-form").removeClass('d-none');
            } else {
                $("#paid-form").addClass('d-none');
            }
        });
        $('#currency').change(function () {
            if (this.value == {{ $currency_id ?? '1' }}) {
                $("#exchange-rate").addClass('d-none');
            } else {
                $("#exchange-rate").removeClass('d-none');
            }
        });
        $('#exchange-rate-btn').click(function () {
            var btn = $('#exchange-rate-btn');
            var spin = $('#exchange-rate-spinner');
            btn.addClass('d-none');
            spin.removeClass('d-none');
            var code = $('#currency').find(':selected').data('code');
            var date = $('#payment_date').val();
            axios.get('/api/v1/exchange-rates/' + code + '/' + date)
                .then(function (response) {
                    $('#exchange_rate_input').val(response.data.rate);
                })
                .catch(function (error) {
                    console.log(error);
                }).finally(() => {
                spin.addClass('d-none');
                btn.removeClass('d-none');
            });
        });
    });
</script>
