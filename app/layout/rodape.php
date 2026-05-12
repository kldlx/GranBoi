</div>

<script src="<?= BASE_URL ?>/public/assets/js/core/sidebar.js"></script>

<?php if (!empty($pageJs)): ?>
    <?php foreach ($pageJs as $js): ?>
        <script src="<?= BASE_URL . $js ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>