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
                    <a href="">Синхроный</a>
                </li>
                <li>
                    <a href="">Асинхроный</a>
                </li>
            </ul>
        </div>
    </div>

		<?php m()->render()?>

    <div id="layer_footer">
        <div class="wrapper">
            <table id="footer_container">
                <thead>
                <tr>
                    <td><h3>Посилання</h3></td>
                    <td><h3>SHOOTER</h3></td>
                    <td><h3>Call-центр</h3></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <ul>
                            <li><a href="#">Головна</a></li>
                            <li><a href="#">Галерея</a></li>
                            <li><a href="#">Контакти</a></li>
                        </ul>
                    </td>
                    <td>
                        <p>Lorem ipsum dolor sit amet nec, consectetuer adipiscing elit.
                            Aenemodo ligula eget dolorenean massa. Lorem ipsum dolor sit amet nec.</p>
                        <p>Pancetta beef ribs fatback pastrami bacon turducken ham boudin pork belly sausage,
                            Pancetta beef ribs.</p>
                    </td>
                    <td>
                        <p>Цілодобовий прийом дзвінків</p>
                        <p>Інтернет-система "Галерея"</p>
                        <p>2010–2015</p>
                        <p>Expenect</p>
                        <p>Всі права захищено 2014 р.</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
	</body>
</html>