<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="/js/sb-admin-2.min.js"></script>
<script src="/vendor/chart.js/Chart.min.js"></script>
<script src="/js/demo/chart-area-demo.js"></script>
<script src="/js/demo/chart-pie-demo.js"></script>
<script src="/js/demo/chart-bar-demo.js"></script>
<script src="/assets/js/combined.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id=sb&currency=USD&disable-funding=card&intent=authorize"></script>
<script>
  paypal.Buttons({
    style: {
      layout: 'vertical',
      color: 'gold',
      shape: 'pill',
      label: 'pay',
    }
  }).render('#paypal-button-container');
</script>
<script>
  document.getElementById("submit").addEventListener("click", function(event) {
    event.preventDefault();

    let validate = false;

    let commentContent = document.getElementById("form-comment"),
      commentHeader = document.getElementById("form-username"),
      commentError = document.getElementById("error-comment"),
      headerError = document.getElementById("error-username");

    if (commentHeader.value.length == 0 || commentContent.value.length == 0) {
      if (commentHeader.value.length == 0) {
        commentHeader.classList.add("is-invalid");
        headerError.classList.remove("invisible");
        headerError.classList.add("visible");
        headerError.innerHTML = "Username field is required.";
      } else {
        commentHeader.classList.remove("is-invalid");
        headerError.classList.remove("visible");
        headerError.classList.add("invisible");
      }
      if (commentContent.value.length == 0) {
        commentContent.classList.add("is-invalid");
        commentError.classList.remove("invisible");
        commentError.classList.add("visible");
        commentError.innerHTML = "Comment field is required.";
      } else {
        commentContent.classList.remove("is-invalid");
        commentError.classList.remove("visible");
        commentError.classList.add("invisible");
      }
    } else {
      commentHeader.classList.remove("is-invalid");
      commentContent.classList.remove("is-invalid");

      commentError.classList.remove("invisible");
      headerError.classList.remove("invisible");
      commentError.classList.remove("visible");
      headerError.classList.remove("visible");

      let comment = `<div id="comment" class="mt-2">
            <div class="card p-4">
              <!--<button type="button" class="btn btn-sm btn-dark">
                <i class="fa fa-trash" aria-hidden="true"></i>
              </button>-->
              <div class="media">
                <img src="https://pbs.twimg.com/profile_images/1259926100261601280/OgmLtUZJ_400x400.png" class="mr-3 rounded" style="height: 64px; width: 64px;">
                  <div class="media-body">
                    <h5 class="mt-1">${commentHeader.value}</h5>
                    <div id="commentContent">${commentContent.value}</div>
                  </div>
                </div>
              </div>
          </div>`;

      let comments = document.getElementById("comments");
      comments.innerHTML += comment;
    }


  });
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/decoupled-document/ckeditor.js"></script>
<script>
  DecoupledEditor
    .create(document.querySelector('#editor'), {
      ckfinder: {
        uploadUrl: "{{route('ckeditor.upload',['_token'=>csrf_token()])}}",
      },
    })
    .then(editor => {
      editor.editing.view.document.isReadOnly = true;
      editor.enableReadOnlyMode('feature-id');
      const toolbarContainer = document.querySelector('#toolbar-container');

      toolbarContainer.appendChild(editor.ui.view.toolbar.element);
    })
    .catch(error => {
      console.error(error);
    });
</script>
<script src="/js/landing_combined.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const accordionItems = document.querySelectorAll('.accordion-item');

    accordionItems.forEach(item => {
      item.addEventListener('click', () => {
        item.classList.toggle('open');

        // Close other open items
        accordionItems.forEach(otherItem => {
          if (otherItem !== item && otherItem.classList.contains('open')) {
            otherItem.classList.remove('open');
          }
        });
      });
    });
  });
</script>


<script>
  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
  }
</script>


<script>
  // JavaScript validation to prevent non-numeric input
  document.getElementById('gcash').addEventListener('input', function(e) {
    // Remove non-numeric characters from input value
    e.target.value = e.target.value.replace(/[^\d]/g, '');
  });
</script>

<script src="/js/questions1.js"></script>
<!-- Inside this JavaScript file I've coded all Quiz Codes -->
<script src="/js/script1.js"></script>

<script>
  quit_quiz.onclick = () => {
    window.location.href = "{{ route('student.courses') }}";
  }
</script>

<script>
  function toggleCourseDetails(transactionId) {
    var courseDetailsRows = document.querySelectorAll('[id^="course-details-' + transactionId + '"]');
    courseDetailsRows.forEach(function(row) {
      if (row.style.display === 'none') {
        row.style.display = 'table-row';
      } else {
        row.style.display = 'none';
      }
    });
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.min.js"></script>
<script>
  new DataTable('#myTable12345');
</script>
<script>
  new DataTable('#myTable123456');
</script>