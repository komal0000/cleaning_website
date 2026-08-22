@push('scripts')
<script>
document.querySelectorAll('[data-position]').forEach((link) => link.addEventListener('click', () => {
    const select = document.getElementById('careerPosition');
    if (select) select.value = link.dataset.position;
}));
</script>
@endpush
