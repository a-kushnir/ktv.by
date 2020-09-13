<div class="page-header">
<h1>Способы оплаты</h1>
</div>

<?php function payment_info(){ ?>
  <h5>Как узнать номер лицевого счета?</h5>
  <ol>
    <li>Во время заключения договора в офисе (как правило, номер лицевого счета совпадает с номером сотового телефона, который вы указали)
    <li>Посмотреть в памятке абонента, которую можно получить в офисе или заказать у <a href="/contact">диспетчера</a>
    <li>Войти в <a href="/logon">панель управления</a> и посмотреть на странице "Общая информация"
    <li>Позвонить нашему <a href="/contact">диспетчеру</a>
  </ol>
  
  <h5>Как узнать свой баланс?</h5>
  <ol>
    <li>Войти в <a href="/logon">панель управления</a> и посмотреть на странице "Общая информация"
    <li>Позвонить нашему <a href="/contact">диспетчеру</a>
  </ol>
<?php } ?>

<div class="span8 offset2">

<p>Для Вышего удобства мы предусмотрели различные способы оплаты:</p>

<div class="accordion" id="payments">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#payments" href="#pay_belbank">
        <img src="/images/pay_belbank.jpg" /> В любом отделении АСБ «Беларусбанк»
      </a>
    </div>
    <div id="pay_belbank" class="accordion-body collapse">
      <div class="accordion-inner">
        <ol>
          <li>Получите квитанцию или памятку абонента в офисе или по почте
          <li>Предъявите квитанцию или памятку абонента в банке и оплатите услуги TeleSputnik
        </ol>
        <?php payment_info(); ?>
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#payments" href="#pay_belpost">
        <img src="/images/pay_belpost.jpg" /> В любом отделении РО «Белпочта»
      </a>
    </div>
    <div id="pay_belpost" class="accordion-body collapse">
      <div class="accordion-inner">
        <ol>
          <li>Получите квитанцию или памятку абонента в офисе или по почте
          <li>Предъявите квитанцию или памятку абонента на почте и оплатите услуги TeleSputnik
        </ol>
        <?php payment_info(); ?>
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#payments" href="#pay_erip">
        <img src="/images/pay_erip.jpg" /> При помощи системы «Расчёт» (ЕРИП)
      </a>
    </div>
    <div id="pay_erip" class="accordion-body collapse">
      <div class="accordion-inner">
        <ol>
          <li>Для оплаты наших услуг в меню услуг ЕРИП выберите получателя "TeleSputnik Ltd." в разделе «Интернет, Кабельное ТВ (г. Брест)».
          <li>При осуществлении оплаты вам необходимо указать номер лицевого счета (7 цифр), который, как правило, совпадает с номером мобильного телефона.
        </ol>
        <?php payment_info(); ?>
      </div>
    </div>
  </div>
</div>

</div>
</div>