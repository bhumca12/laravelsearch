<!DOCTYPE html>
<html>
  <head>
    <title>Simple registration form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <style>
      html, body {
      display: flex;
      justify-content: center;
      height: 100%;
      }
      body, div, h1, form, input, p { 
      padding: 0;
      margin: 0;
      outline: none;
      font-family: Roboto, Arial, sans-serif;
      font-size: 16px;
      color: #666;
      }
      h1 {
      padding: 10px 0;
      font-size: 32px;
      font-weight: 300;
      text-align: center;
      }
      p {
      font-size: 12px;
      }
      hr {
      color: #a9a9a9;
      opacity: 0.3;
      }
      .main-block {
      max-width: 340px; 
      min-height: 460px; 
      padding: 10px 0;
      margin: auto;
      border-radius: 5px; 
      border: solid 1px #ccc;
      box-shadow: 1px 2px 5px rgba(0,0,0,.31); 
      background: #ebebeb; 
      }
      form {
      margin: 0 30px;
      }
      .account-type, .gender {
      margin: 15px 0;
      }
      input[type=radio] {
      display: none;
      }
      label#icon {
      margin: 0;
      border-radius: 5px 0 0 5px;
      }
      label.radio {
      position: relative;
      display: inline-block;
      padding-top: 4px;
      margin-right: 20px;
      text-indent: 30px;
      overflow: visible;
      cursor: pointer;
      }
      label.radio:before {
      content: "";
      position: absolute;
      top: 2px;
      left: 0;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: #1c87c9;
      }
      label.radio:after {
      content: "";
      position: absolute;
      width: 9px;
      height: 4px;
      top: 8px;
      left: 4px;
      border: 3px solid #fff;
      border-top: none;
      border-right: none;
      transform: rotate(-45deg);
      opacity: 0;
      }
      input[type=radio]:checked + label:after {
      opacity: 1;
      }
      input[type=text], input[type=password] {
      width: calc(100% - 57px);
      height: 36px;
      margin: 13px 0 0 -5px;
      padding-left: 10px; 
      border-radius: 0 5px 5px 0;
      border: solid 1px #cbc9c9; 
      box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
      background: #fff; 
      }
      input[type=password] {
      margin-bottom: 15px;
      }
      #icon {
      display: inline-block;
      padding: 9.3px 15px;
      box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
      background: #1c87c9;
      color: #fff;
      text-align: center;
      }
      .btn-block {
      margin-top: 10px;
      text-align: center;
      }
      button {
      width: 100%;
      padding: 10px 0;
      margin: 10px auto;
      border-radius: 5px; 
      border: none;
      background: #1c87c9; 
      font-size: 14px;
      font-weight: 600;
      color: #fff;
      }
      button:hover {
      background: #26a9e0;
      }
      @import url("https://fonts.googleapis.com/css?family=Open+Sans");

/* Styles */
* {
  margin: 0;
  padding: 0;
}

body {
  font-family: "Open Sans";
  font-size: 14px;
}

.container {
  width: 500px;
  margin: 25px auto;
}

form {
  padding: 20px;
  background: #2c3e50;
  color: #fff;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  border-radius: 4px;
}


form button {
  height: 30px;
  line-height: 30px;
  background: #e67e22;
  color: #fff;
  margin-top: 10px;
  cursor: pointer;
}
form .error {
  color: #ff0000;
}
    </style>
  </head>
  <body>
    <div class="container">
      <h1>Registration</h1>
      <form action="{{ route('post.store') }}" method="post" name="registration">
      @csrf
        <label id="icon" for="name"><i class="fas fa-user"></i></label>
        <input type="text" name="firstname" id="firstname" placeholder="Name" />
        <br/>
        <label id="icon" for="name"><i class="fas fa-envelope"></i></label>
        <input type="text" name="email" id="email" placeholder="Email" required/>
        <br>
        
        <label id="icon" for="mobile"><i class="fas fa fa-mobile"></i></label>
        <input type="text" name="mobile" id="mobile" placeholder="mobile"  maxlength='10' minlength='10'required/>
        <br>
        <label id="icon" for="pincode"><i class="fa fa-pinterest-p"></i></label>
        <input type="text" name="pincode" id="pincode" placeholder="pincode" maxlength='7' minlength='7' required/>
        <br>
        <div class="btn-block">
          <button type="submit">Submit</button>
        </div>
      </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
   


    <script>
        $(function() {
        
        $("form[name='registration']").validate({
          
            rules: {
            
                firstname: "required",
           
            email: {
                required: true,
               
                email: true
            },
            mobile: {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            pincode: {
                required: true,
                minlength: 7,
                maxlength: 7
            }

            },
           
            messages: {
            firstname: "Please enter your name",
            email: "Please enter a valid email address",
            mobile: "Please enter a valid mobile number",
            pincode: "Please enter a valid pincode maximum 7 and minimum 7"
            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form) {
            form.submit();
            }
        });
        });
    </script>
  </body>
</html>