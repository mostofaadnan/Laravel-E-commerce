<!-- <div class="contact_message form">
    <h3>Contact Us</h3>
    <p>
        <label> Your Name (required)</label>
        <input name="name" placeholder="Name *" id="contactname" type="text">
    </p>
    <p>
        <label> Your Email (required)</label>
        <input name="email" placeholder="Email *" id="contactemail" type="email">
    </p>
    <p>
        <label> Subject</label>
        <input name="subject" placeholder="Subject *" id="contactsubject" type="text">
    </p>
    <div class="contact_textarea">
        <label> Your Message</label>
        <textarea placeholder="Message *" name="message" id="contactmessage" class="form-control2"></textarea>
    </div>
    <button type="submit" id="submitcontact"> Send</button>
    <p class="form-messege"></p>

</div> -->


<section class="ptb-60">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="heading-part line-bottom mb-20">
            <h2 class="main_title  heading"><span>Leave a message!</span></h2>
          </div>
        </div>
      </div>
      <div class="main-form">
       
          <div class="row mlr_-20">
            <div class="col-md-4 mb-20 plr-20">
              <input type="text" required placeholder="Name" id="contactname">
            </div>
            <div class="col-md-4 mb-20 plr-20">
              <input type="email" required placeholder="Email" id="contactemail">
            </div>
            <div class="col-md-4 mb-20 plr-20">
              <input type="text" required placeholder="Subject" id="contactsubject">
            </div>
            <div class="col-12 mb-20 plr-20">
              <textarea required placeholder="Message" rows="3" cols="30" id="contactmessage"></textarea>
            </div>
            <div class="col-12 plr-20">
              <div class="align-center">
                <button type="submit" name="submit" class="btn btn-color" id="submitcontact">Submit</button>
              </div>
            </div>
          </div>
       
      </div>
    </div>
  </section>
<script>
    $(document).on('click', "#submitcontact", function() {
        var names = $("#contactname").val();
        var emails = $("#contactemail").val();
        var subjects = $("#contactsubject").val();
        var messages = $("#contactmessage").val();
        if (emails == "" || names == "" || subjects == "" || messages == "") {
            swal("!Opps", "Requirment Field Is Empty", "error");
        } else {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (regex.test(emails) == true) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('contactus.store') }}",
                    data: {
                        name: names,
                        email: emails,
                        subject: subjects,
                        message: messages
                    },
                    success: function() {
                        swal("Succcse", "Thank you for send message,We are contact you", "success");
                        $("#contactname").val("");
                        $("#contactemail").val("");
                        $("#contactsubject").val("");
                        $("#contactmessage").val("");
                    },
                    error: function() {
                        swal("!sorry", "Something wrong", "error");
                    }

                });

            } else {
                swal("!Opps", "Your Email is not valid", "error");
            }
        }
    });
</script>