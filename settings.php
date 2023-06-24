<div>
    <h1><span style="color: orange;">Custom Download WP</span> — Настройки</h1>
    <form method="post" action="options.php">
		<?php settings_fields('cdwp_options_group'); ?>
        <table class="form-table">

            <tr>
                <th scope="row">Использовать свои стили?</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Использовать свои стили?</span></legend>
                        <label for="cdwp_default_style">
                            <input name="cdwp_default_style" type="checkbox" id="cdwp_default_style" value="1" <?php checked('1', get_option('cdwp_default_style')); ?>>
                        </label>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row">Убрать кнопку над редактором?</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Добавить кнопку над редактором?</span></legend>
                        <label for="cdwp_media_button">
                            <input name="cdwp_media_button" type="checkbox" id="cdwp_media_button" value="1" <?php checked('1', get_option('cdwp_media_button')); ?>>
                        </label>
                    </fieldset>
                </td>
            </tr>
        </table>
		<?php submit_button(); ?>
    </form>
</div>