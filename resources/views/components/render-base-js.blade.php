<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="{{ asset('js/helpers.js?=').time() }}"></script>
<script src="{{ asset('js/tracker/user-tracking-log.js?=').time() }}"></script>
<script>
    $(document).ready(function() {
        USER_TRACKING_LOG.init({
            user_id: '{{ Auth::check() ? Auth::user()->id : null }}',
        });
    });
</script>