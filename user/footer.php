<!-- <?php
// footer.php
?>
    <footer style="background:#111; color:#ccc; text-align:center; padding:15px; margin-top:40px;">
        <p>&copy; <?php echo date("Y"); ?> PromptGallery. All rights reserved.</p>
    </footer>

    <script>
        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert("Prompt copied!");
            });
        }
    </script>
</body>
</html> -->

<?php
// footer.php

$footerStyle = "background:#111; color:#ccc; text-align:center; padding:15px;";

if (isset($fixedFooter) && $fixedFooter === true) {
    $footerStyle .= " position:fixed; left:0; bottom:0; width:100%;";
} else {
    $footerStyle .= " margin-top:40px;";
}
?>
    <footer style="<?php echo $footerStyle; ?>">
        <p>&copy; <?php echo date('Y'); ?> PromptGallery. All rights reserved.</p>
    </footer>

    <script>
        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert("Prompt copied!");
            });
        }
    </script>
</body>
</html>
