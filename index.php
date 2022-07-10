<?php require_once 'model.php'; ?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>test</title>
        <meta charset ="UTF-8" />
        <meta name="viewport" content ="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/ico" href="/favicon.ico" sizes="16x16" />
        <link 
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" 
            crossorigin="anonymous"
        >
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="offset-1 offset-sm-3 offset-xl-4 col-10 col-sm-6 col-xl-4 ">
                    <h1 class="text-center text-primary mt-3">Test</h1>
                    <form class="was-validated form-request" method="POST" action="model.php">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="invalid-feedback">Enter your name!</div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="tel" class="form-control phone-field" id="phone" name="phone" required>
                            <div class="invalid-feedback">Enter your phone!</div>
                        </div>
                        <input type="submit" class="btn btn-primary mb-5" value="Send" disabled>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table">
                        <thead class="text-white bg-primary">
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($persons as $person) : ?>
                            <tr>  
                                <td><?php echo $person['id']; ?></td>
                                <td><?php echo $person['name']; ?></td>
                                <td><?php echo $person['phone']; ?></td>
                                <td><?php echo $person['date']; ?></td>
                            </tr>
                            <?php endforeach; ?>                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('.phone-field').inputmask("+7(999)999-99-99");
                
                jQuery.validator.addMethod("checkMaskPhone", function(value, element) {
                    return /\+\d{1}\(\d{3}\)\d{3}-\d{2}-\d{2}/g.test(value); 
                });
        
                var form = $('.form-request');
        
                form.validate();
        
                $.validator.addClassRules({
                    'phone-field': {
                        checkMaskPhone: true,
                    }
                });

                $('.phone-field').on('input', function() {
                    if (form.valid()) {
                        $('.btn').removeAttr('disabled');
                        sendForm(form);
                    } else {
                        $('.btn').attr('disabled');
                    }
                });

                function sendForm(form) {
                    form.submit(function(e) {
                        var $form = $(this);
                        $.ajax({
                            type: $form.attr('method'),
                            url: $form.attr('action'),
                            cache: false,
                            data: $form.serialize()
                        })
                        .done(function(responce) { 
                            $('tbody').html('');
                            let persones = JSON.parse(responce);
                            persones.forEach(function(index) {
                                $('tbody').append(`<tr><td>${index['id']}</td><td>${index['name']}</td><td>${index['phone']}</td><td>${index['date']}</td></tr>`);
                            });
                        }).fail(function(e) {
                            console.log('fail');
                        });
                        e.preventDefault(); 
                    });
                }
            });
        </script>
    </body>
</html>
