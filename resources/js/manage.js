$(function () {
  let indicateContent;
  $('.indicate-btn').on('click', function (event) {
    event.preventDefault();
    let $this = $(this);
    indicateContent = $this.data('indicate-content');

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/managements/more',
      type: 'get',
      data: {
        'indicate_content': indicateContent,
      },
    })
      .done(function (data) {
        $('.result').html(data['list']);
      })
      .fail(function () {
        alert('error');
      });
  });
});