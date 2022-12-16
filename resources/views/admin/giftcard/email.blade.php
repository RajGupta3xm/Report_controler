<!-- <!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.png')}}">
        <title>Diet-on</title> 
    </head>
    <body>
        <p>Hello {{$name}},</p>
        
        <p> {{$query}}</p>
        <hr>
        <p>Your Voucher Code {{$voucher_code}}</p>
        <br>
        <p>Your Voucher pin {{$voucher_pin}}</p>
        <br>
        <p>Regards</p>
        <p>Team Diet-on</p>
    </body>
</html> -->

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>Freshtrader</title>
      <meta content="" name="description" />
      <meta content="" name="keywords" />
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
   </head>
   <body style="font-family: 'Poppins', sans-serif; margin: 0;">
      <tr>
         <td style="border: 0;">
            <table width="600" style="margin: 0 auto; border: 0; border-spacing: 0;">
               <tr>
                  <td style="padding: 20px; background-color: #eef3ff; border-bottom: 6px solid #FFC700; border-top: 6px solid #00B65E;">
                     <table width="100%" style="margin: 0 auto; border: 0;">
                        <tr>
                           <td style="text-align: center; padding-bottom: 30px;">
                              <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                 <tr>
                                    <td style="text-align: center;padding-bottom: 20px;">
                                       <img style="display: inline-block; max-width: 134px;" src="{{asset('assets/img/logo.png')}}" alt="Diet On">
                                    </td>
                                 </tr>
                                 <tr>
                                    <td style="text-align: center; font-size: 18px;font-weight: 500;">
                                       You Have Received a gift card of Diet On from
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td style="padding-bottom: 20px;">
                              <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                 <tr>
                                    <td style="width: 30%; background-color: #FFC700; border-radius: 10px 0 0 10px; padding: 10px 10px; vertical-align: top;">
                                       <table width="100%" style="margin: 0 auto; border: 0;">
                                          <tr>
                                             <td style="background-color: #fff; display: inline-block; height: 80px;
                                                line-height: 92px; width: 110px; text-align: center; border-radius: 10px;">
                                                <img style="display: inline-block; max-width: 70px;" src="img/logo.png" alt="Diet On">
                                             </td>
                                          </tr>
                                       </table>
                                    </td>
                                    <td style="width: 70%; background-color: #00B65E; border-radius: 0px 10px 10px 0;
                                       padding: 20px;">
                                       <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                          <tr>
                                             <td style="text-align: left; font-size: 20px;font-weight: 500; color: #fff; padding-bottom: 10px;">
                                                ₹100
                                             </td>
                                          </tr>
                                          <tr>
                                             <td style="padding-bottom: 10px;">
                                                <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                                   <tr>
                                                      <td style="text-align: left; font-size: 14px;font-weight: 400; color: #fff; padding-bottom: 6px;">
                                                         VOUCHER CODE
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td style="text-align: left; font-size: 14px; font-weight: 400; color: #000; padding: 7px 10px; background-color: #fff; display: inline-flex;">
                                                      {{$voucher_code}}
                                                      </td>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td style="padding-bottom: 10px;">
                                                <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                                   <tr>
                                                      <td style="text-align: left; font-size: 14px;font-weight: 400; color: #fff; padding-bottom: 0;">
                                                         VOUCHER PIN
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td style="text-align: left; font-size: 14px; font-weight: 400; color: #000; display: inline-flex;">
                                                      {{$voucher_pin}}
                                                      </td>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                                   <tr>
                                                      <td style="text-align: left; font-size: 14px;font-weight: 400; color: #fff; padding-bottom: 0;">
                                                         EXPIRES: UNDEFINED DATE UNDEFINED
                                                      </td>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td style="padding-bottom: 20px;">
                              <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                 <tr>
                                    <td style="text-align: left; font-size: 15px;font-weight: 600; color: #000; padding-bottom: 4px;">
                                       Attached Message :
                                    </td>
                                 </tr>
                                 <tr>
                                    <td style="text-align: left; font-size: 14px;font-weight: 400; color: #000; padding-bottom: 0;">
                                       Lorem ipsum dolor sit amet.
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td style="padding-bottom: 20px;">
                              <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                 <tr>
                                    <td style="text-align: left; font-size: 15px;font-weight: 600; color: #000; padding-bottom: 4px;">
                                       Here's how to use it : 
                                    </td>
                                 </tr>
                                 <tr>
                                    <td style="text-align: left; font-size: 14px;font-weight: 400; color: #000; padding-bottom: 0;">
                                       Visit <a style="text-decoration: none; font-size: 14px;font-weight: 500; color: #00B65E; padding-bottom: 0;" href="javascript:;">here</a> for the steps to redeem the voucher.
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr> 
                        <tr>
                           <td style="padding-bottom: 20px;">
                              <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                 <tr>
                                    <td style="text-align: left; font-size: 15px;font-weight: 600; color: #000; padding-bottom: 4px;">
                                       Terms & Conditions : 
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>
                                       <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                          <tr>
                                             <td style="text-align: left; font-size: 14px;font-weight: 400; color: #000; padding-bottom: 5px;">
                                                1. On buying this voucher you will get a code through which you can purchase any products.
                                             </td>
                                          </tr>
                                          <tr>
                                             <td style="text-align: left; font-size: 14px;font-weight: 400; color: #000; padding-bottom: 5px;">
                                                2. Valid for 180 days.
                                             </td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                                
                              </table>
                           </td>
                        </tr>

                        <tr>
                           <td style="background-color: #fff; padding: 15px;">
                              <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                 <tr>
                                    <td style="width: 40%; vertical-align: middle;">
                                       <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                          <tr>
                                             <td style="text-align: left; font-size: 14px;font-weight: 600; color: #000; padding-bottom: 6px;">
                                                Order Details : 
                                             </td>
                                          </tr>
                                          <tr>
                                             <td style="text-align: left; font-size: 13px;font-weight: 400; color: #000; padding-bottom: 2px;">
                                                Order No. <span style="font-size: 13px;font-weight: 400; color: #000;">16741223643 </span>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td style="text-align: left; font-size: 13px;font-weight: 400; color: #000; padding-bottom: 0;">
                                                Fri, 24 Dec 2021, 15:29:28
                                             </td>
                                          </tr>
                                       </table>
                                    </td>
                                    <td style="width: 60%;">
                                       <table width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                                          <tr>
                                             <td style="text-align: right; padding-bottom: 4px;">
                                                <a style="text-decoration: none; display: inline-block;" href="javascript:;"><img style="display: inline-block; max-width: 110px;" src="img/logo.png" alt="Diet On"></a>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td style="text-align: right; font-size: 13px;font-weight: 400; color: #000; padding-bottom: 0;">
                                                B-121, Sector 5, Noida, Uttar Pradesh - 201301
                                             </td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
   </body>
</html>

