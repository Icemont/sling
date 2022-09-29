<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#attributes').on('click', '.attributes-remove', function () {
            $(this).closest('.row').remove();
        });
        $('#attributes-add').on('click', function () {
            var tpl = $('template.attributes-tpl').html();
            $('#attributes').append(tpl);
        });
    }, false);
</script>
