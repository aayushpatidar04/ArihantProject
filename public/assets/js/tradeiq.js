document.addEventListener('DOMContentLoaded', function () {
  // --- FAQ accordion: real CSS module already defines the open/closed look,
  // we just need to toggle the "show answer" class the original React app used.
  document.querySelectorAll('.FAQ_qna_cntnr__uCCF2').forEach(function (item) {
    var q = item.querySelector('.FAQ_ques__n_w2h');
    var a = item.querySelector('.FAQ_ans__dQU4r');
    if (!q || !a) return;
    q.style.cursor = 'pointer';
    q.addEventListener('click', function () {
      var isOpen = a.classList.contains('FAQ_show_ans__1iWjO');
      document.querySelectorAll('.FAQ_ans__dQU4r.FAQ_show_ans__1iWjO').forEach(function (open) {
        open.classList.remove('FAQ_show_ans__1iWjO');
      });
      if (!isOpen) a.classList.add('FAQ_show_ans__1iWjO');
    });
  });

  // --- Mobile nav toggle
  var menuBtn = document.querySelector('.TradeIQHeader_menu_button__Cfg7y');
  var navLinks = document.querySelector('.TradeIQHeader_carnival_links___dUpj');
  if (menuBtn && navLinks) {
    menuBtn.addEventListener('click', function () {
      navLinks.classList.toggle('nav-open');
    });
  }

  // --- Event Outline tab switch (visual state only — this static export only
  // captured the TradeIQ tab's session list; wire InvestIQ's own list here
  // once you have that content, or fetch it from your Laravel backend)
  document.querySelectorAll('.EventOutline_tab_btn__O10Kp').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.EventOutline_tab_btn__O10Kp').forEach(function (b) {
        b.classList.remove('EventOutline_tab_active__HNUuB');
      });
      btn.classList.add('EventOutline_tab_active__HNUuB');
    });
  });
});
