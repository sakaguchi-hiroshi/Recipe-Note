$(function () {
  $('form').submit(function () {
    $(this).find(':submit').prop('disabled', 'true');
  });
});

$(function () {
  // let indicateBtn = $('#indicate-btn');
  let indicateContent;
  $('.indicate-btn').on('click', function () {
    let $this = $(this);
    indicateContent = $this.data('indicate-content');

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/managements',
      method: 'GET',
      data: {
        'indicate_content': indicateContent,
      },
    })
      .done(function (data) {
        
        $('#result').append(data['list']);
        console.log(data['list']);
      })
      .fail(function () {
        alert('error');
      });
  });
});

// data.param

