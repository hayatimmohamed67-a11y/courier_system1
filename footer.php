<!-- ===== FOOTER ===== -->
    <div style="text-align:center;margin-top:35px;padding:20px 0;color:#9ca3af;font-size:13px;border-top:1px solid #e5e7eb;">
        &copy; <?= date('Y') ?> CourierPro Management System — Built with <i class="fas fa-heart" style="color:#EF4444;"></i> in Somalia
    </div>

</div><!-- end main -->

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.querySelector('.hamburger');
        if (window.innerWidth < 768) {
            if (!sidebar.contains(e.target) && !hamburger.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
</script>

</body>
</html>