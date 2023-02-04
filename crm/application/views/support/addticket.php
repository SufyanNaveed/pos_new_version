<article class="content">
    <div class="card card-block">
        <?php if ($response == 1) {
            echo '<div id="notify" class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message">' . $responsetext . '</div>
        </div>';

        } else if ($response == 0) {
            echo '<div id="notify" class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message">' . $responsetext . '</div>
        </div>';
        }
        else {
        ?>
        <div class="grid_3 grid_4">


            <?php echo form_open_multipart('tickets/addticket'); ?>

            <h5>Add New Ticket</h5>
            <hr>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Subject') ?></label>

                <div class="col-sm-10">
                    <input type="text" placeholder="Ticket Subject"
                           class="form-control margin-bottom  required" name="title">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 control-label"
                       for="edate"><?php echo $this->lang->line('Description') ?></label>

                <div class="col-sm-10">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10" name="content"></textarea>
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="name">Attach </label>

                <div class="col-sm-6">

                    <small>(docx, docs, txt, pdf, xls, png, jpg, gif)</small>        <button class="btn btn-sm btn-blue tr_clone_add"><?php echo $this->lang->line('add_row') ?></button>
                </div>
            </div>
                 <table class="table" id="v_var">
                                    <tr> <td> </td>
                                        <td>  <input type="file" name="userfile[]" size="20"/><br></td>

                                    </tr>
                                </table>
            <?php if ($captcha_on) {
                echo '<script src="https://www.google.com/recaptcha/api.js"></script>
									 <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4"><fieldset class="form-group position-relative has-icon-left">
                                      <div class="g-recaptcha" data-sitekey="' . $captcha . '"></div>
                                    </fieldset></div>
                </div>';
            } ?>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" class="btn btn-success margin-bottom"
                           value="Add" data-loading-text="Adding...">

                </div>
            </div>


            </form>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(function () {
        $(document).on('click', ".tr_clone_add", function (e) {
        e.preventDefault();
        var n_row = $('#v_var').find('tbody').find("tr:last").clone();

        $('#v_var').find('tbody').find("tr:last").after(n_row);

    });
        $('.summernote').summernote({
            height: 250,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });
    });
</script>
<?php } ?>