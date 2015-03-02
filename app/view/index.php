<html>
	<head>
        <title><?php iv('title')?></title>
	</head>
	
	<body id="<?php iv('id')?>">
    <div id="layer_head">
        <div class="wrapper">
            <a href="">
                <div id="logo"></div>
            </a>
            <ul id="menu">
                <li>
                    <a href=""><?php t('Synchronous');?></a>
                </li>
                <li>
                    <a href=""><?php t('Asynchronous');?></a>
                </li>
            </ul>
        </div>
    </div>
        <?php m('i18n')->render('list')?>
		<?php m()->render()?>

    <div id="layer_footer">
        <div class="wrapper">
            <table id="footer_container">
                <thead>
                <tr>
                    <td><h3><?php t('Link');?></h3></td>
                    <td><h3>SHOOTER</h3></td>
                    <td><h3><?php t('Contacts');?></h3></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <ul>
                            <li>
                                <a href=""><?php t('Synchronous');?></a>
                            </li>
                            <li>
                                <a href=""><?php t('Asynchronous');?></a>
                            </li>
                        </ul>
                    </td>
                    <td>
                        <p>Lorem ipsum dolor sit amet nec, consectetuer adipiscing elit.
                            Aenemodo ligula eget dolorenean massa. Lorem ipsum dolor sit amet nec.</p>
                        <p>Pancetta beef ribs fatback pastrami bacon turducken ham boudin pork belly sausage,
                            Pancetta beef ribs.</p>
                    </td>
                    <td>
                        <p><?php t('Hour reception calls')?></p>
                        <p><?php t('Internet-system "Gallery"')?></p>
                        <p><?php t('All rights reserved 2015');?></p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
	</body>
</html>