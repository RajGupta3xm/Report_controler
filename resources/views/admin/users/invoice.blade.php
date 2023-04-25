<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>Canny</title>
      <meta content="" name="description" />
      <meta content="" name="keywords" />
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
   </head>
   <body style="font-family: 'Nunito Sans', sans-serif; margin: 0; padding: 30px;">
      <tr>
         <td style="border: 0;">
            <table width="100%" style="margin: 0 auto; border: 0;">
               <tr>
                   <td style="padding-bottom: 25px;">
                     <table width="100%" style="margin: 0 auto; border: 0;">
                        <tr>
                           <td style="width: 50%; text-align: start;">
                              <table width="100%" style="margin: 0 auto; border: 0;">
                                 <tr>
                                    <td style="font-size: 28px; font-weight: 800; display: inline-block; color: #000; padding-bottom: 15px;">
                                       Tax Invoice
                                    </td>
                                 </tr>
                                 <tr>
                                    <td style="font-size: 16px; font-weight: 800; display: inline-block; color: #000;">
                                       Order No. <span style="font-size: 16px; font-weight: 500; display: inline-block; color: #000;">{{$orderId}}</span>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td style="font-size: 16px; font-weight: 800; display: inline-block; color: #000;">
                                       Order Date <span style="font-size: 16px; font-weight: 500; display: inline-block; color: #000;">{{\Carbon\Carbon::parse($created_at)->format('d/m/Y')}}</span>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td style="font-size: 16px; font-weight: 800; display: inline-block; color: #000;">
                                       Payment <span style="font-size: 16px; font-weight: 500; display: inline-block; color: #000;">Aps-payments-app-prod</span>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                           <td style="width: 50%; text-align: right;">
                              <table width="100%" style="margin: 0 auto; border: 0;">
                                 <tr>
                                    <td>
                                       <a style="display: block;" target="_blank" href="https://shop.diet-watchers.com/">
                                          <img style="max-width: 100%; margin: 0 auto;" src="img/logo.png" alt="">
                                       </a>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>  
                     </table>
                   </td>
               </tr> 
               <tr>
                  <td>
                    <table width="100%" style="margin: 0 auto; border: 0;">
                       <tr>
                          <td style="width: 10%; text-align: start; vertical-align: top;">
                             <table width="100%" style="margin: 0 auto; border: 0;">
                                <tr>
                                   <td style="font-size: 16px; font-weight: 800; display: inline-block; color: #000;">
                                    Bill to
                                   </td>
                                </tr>  
                             </table>
                          </td>
                          <td style="width: 90%; text-align: start;">
                             <table width="100%" style="margin: 0 auto; border: 0;">
                                 <tr>
                                    <td style="font-size: 16px; font-weight: 500; display: inline-block; color: #000;">
                                    {{$name}}
                                    </td>
                                 </tr> 
                                 <tr>
                                    <td style="font-size: 16px; font-weight: 500; display: inline-block; color: #000;">
                                       {{$address}}
                                    </td>
                                 </tr> 
                                 <tr>
                                    <td style="font-size: 16px; font-weight: 500; display: inline-block; color: #000;">
                                       Riyadh
                                    </td>
                                 </tr> 
                                 <tr>
                                    <td style="font-size: 16px; font-weight: 500; display: inline-block; color: #000;">
                                       Mobile. {{$mobile}}
                                    </td>
                                 </tr> 
                                 <tr>
                                    <td style="font-size: 16px; font-weight: 700; display: inline-block; color: #000;">
                                       Email: {{$email}}
                                    </td>
                                 </tr> 
                             </table>
                          </td>
                       </tr>  
                    </table>
                  </td>
               </tr> 
               <tr>
                  <td style="padding: 35px 0 50px;">
                     <table class="table" width="100%" style="margin: 0 auto; border: 0; border-spacing: 0;">
                        <thead>
                           <tr>
                              <th style="font-size: 16px; font-weight: 700; text-align: start; color: #000; padding: 14px 18px;border-top: 4px solid #000; border-bottom: 4px solid #000;">Item Description </th>
                              <th style="font-size: 16px; font-weight: 700; text-align: center; color: #000; padding: 14px 18px;border-top: 4px solid #000; border-bottom: 4px solid #000;">Qty</th>
                              <th style="font-size: 16px; font-weight: 700; text-align: center; color: #000; padding: 14px 18px;border-top: 4px solid #000; border-bottom: 4px solid #000;">Price (Inc. Tax)</th>
                              <th style="font-size: 16px; font-weight: 700; text-align: center; color: #000; padding: 14px 18px;border-top: 4px solid #000; border-bottom: 4px solid #000;">Tax</th>
                              <th style="font-size: 16px; font-weight: 700; text-align: center; color: #000; padding: 14px 18px;border-top: 4px solid #000; border-bottom: 4px solid #000;">Price</th>
                              <th style="font-size: 16px; font-weight: 700; text-align: center; color: #000; padding: 14px 18px;border-top: 4px solid #000; border-bottom: 4px solid #000;">Total</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td style="font-size: 16px; font-weight: 600; text-align: strt; color: #000; padding: 14px 18px; background-color: #f2f2f2; border-bottom: 2px solid #e1e1e1;"> {{$planName_ar}}
                                 <br> {{$planName}} -{{$no_days}} day {{$option1}}</td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: #f2f2f2; border-bottom: 2px solid #e1e1e1;">1</td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: #f2f2f2; border-bottom: 2px solid #e1e1e1;">{{$delivery_price}}</td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: #f2f2f2; border-bottom: 2px solid #e1e1e1;">0%</td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: #f2f2f2; border-bottom: 2px solid #e1e1e1;">{{$plan_price}}</td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: #f2f2f2; border-bottom: 2px solid #e1e1e1;">{{$plan_price}}</td>
                           </tr> 
                           <tr>
                              <td style="font-size: 16px; font-weight: 600; text-align: strt; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;" ></td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;"> </td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;"></td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;"></td>
                              <td style="font-size: 16px; font-weight: 700; text-align: start; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 2px solid #e1e1e1;">Subtotal</td>
                              <td style="font-size: 16px; font-weight: 600; text-align: end; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 2px solid #e1e1e1;">{{$plan_price}}</td>
                           </tr> 
                           <tr>
                              <td style="font-size: 16px; font-weight: 600; text-align: strt; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;" ></td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;"> </td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;"></td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;"></td>
                              <td style="font-size: 16px; font-weight: 700; text-align: start; color: #000; padding: 14px 18px; background-color: #f2f2f2; border-bottom: 2px solid #e1e1e1;">Shipping</td>
                              <td style="font-size: 16px; font-weight: 600; text-align: end; color: #000; padding: 14px 18px; background-color: #f2f2f2; border-bottom: 2px solid #e1e1e1;">0.00 س.ر</td>
                           </tr> 
                           <tr>
                              <td style="font-size: 16px; font-weight: 600; text-align: strt; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;" ></td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;"> </td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;"></td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;"></td>
                              <td style="font-size: 16px; font-weight: 700; text-align: start; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 3px solid #000;">Sales Tax (0%) </td>
                              <td style="font-size: 16px; font-weight: 600; text-align: end; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 3px solid #000;">{{$plan_price}}</td>
                           </tr> 
                           <tr>
                              <td style="font-size: 16px; font-weight: 600; text-align: strt; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;" ></td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;"> </td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;"></td>
                              <td style="font-size: 16px; font-weight: 600; text-align: center; color: #000; padding: 14px 18px; background-color: transparent; border-bottom: 0;"></td>
                              <td style="font-size: 16px; font-weight: 800; text-align: start; color: #000; padding: 14px 18px; background-color: #f2f2f2; border-bottom: 3px solid #000;">Total (SAR)</td>
                              <td style="font-size: 16px; font-weight: 600; text-align: end; color: #000; padding: 14px 18px; background-color: #f2f2f2; border-bottom: 3px solid #000;">{{$plan_price}}</td>
                           </tr> 
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td>
                    <table width="100%" style="margin: 0 auto; border: 0;">
                       <tr>
                          <td style="text-align: center;">
                             <table width="100%" style="margin: 0 auto; border: 0;">
                                <tr>
                                   <td style="font-size: 16px; font-weight: 800; display: inline-block; color: #000;">
                                    Thanks for your business!
                                   </td>
                                </tr>
                                <tr>
                                 <td style="font-size: 16px; font-weight: 400; display: inline-block; color: #000;">
                                    If you have any questions, please do get in contact.
                                 </td>
                              </tr> 
                             </table>
                          </td> 
                       </tr>  
                    </table>
                  </td>
               </tr>
               <tr>
                  <td style="padding: 20px 0px;">
                    <table width="100%" style="margin: 0 auto; border: 0;">
                       <tr>
                          <td style="text-align: center;">
                             <table width="100%" style="margin: 0 auto; border: 0;">
                                <tr>
                                   <td style="font-size: 16px; font-weight: 800; display: inline-block; color: #000;">
                                    Al Muthaf Al Methaly
                                   </td>
                                </tr>
                                <tr>
                                 <td style="font-size: 16px; font-weight: 800; display: inline-block; color: #000;">
                                    C.R: 1010448330
                                 </td>
                              </tr> 
                             </table>
                          </td> 
                       </tr>  
                    </table>
                  </td>
               </tr>
               <tr>
                  <td>
                    <table width="100%" style="margin: 0 auto; border: 0;">
                       <tr>
                          <td style="text-align: center;">
                             <table width="100%" style="margin: 0 auto; border: 0;"> 
                                 <tr>
                                    <td style="font-size: 16px; font-weight: 400; display: inline-block; color: #000;">
                                       Al Tumamah Road / Riyadh, 11645 /
                                    </td>
                                 </tr> 
                                 <tr>
                                    <td style="font-size: 16px; font-weight: 600; display: inline-block; color: #000;">
                                       <a style="font-size: 16px; font-weight: 600; display: inline-block; color: #000; text-decoration: none;" href="mailto:support@cannyksa.com">support@cannyksa.com</a>
                                    </td>
                                 </tr> 
                                 <tr>
                                    <td style="font-size: 16px; font-weight: 800; display: inline-block; color: #000;">
                                       <a style="font-size: 16px; font-weight: 800; display: inline-block; color: #000; text-decoration: none;" target="_blank" href="https://shop.diet-watchers.com/">www.cannyksa.com</a>
                                    </td>
                                 </tr> 
                                 <tr>
                                    <td style="padding-top: 10px;">
                                       <table width="9%" style="margin: 0 auto; border: 0;">
                                          <tr>
                                             <td style="width: 33%;">
                                                <a style="text-decoration: none; display: block;" target="_blank" href="javascript:;">
                                                   <img style="display: block; max-width: 25px; margin: 0 auto;" src="{{asset('assets/img/facebook.png')}}" alt="facebook">
                                                </a>
                                             </td>
                                             <td style="width: 33%;">
                                                <a style="text-decoration: none; display: block;" target="_blank" href="javascript:;">
                                                   <img style="display: block; max-width: 25px; margin: 0 auto;" src="img/instagram.png" alt="instagram">
                                                </a>
                                             </td>
                                             <td style="width: 33%;">
                                                <a style="text-decoration: none; display: block;" target="_blank" href="javascript:;">
                                                   <img style="display: block; max-width: 25px; margin: 0 auto;" src="img/twitter.png" alt="Twitter">
                                                </a>
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