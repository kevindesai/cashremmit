<div class="closeHeader">	
 <h2>Document Verification</h2>
 <span class="fa fa-times" aria-hidden="true"></span>
</div>
<div class="container mt3 mb5 docVerify" ng-if="userInfo.is_active == 1">
     <div class="row">
        <div class="col-md-12">
          <h2>CashRemit Document verification</h2>
        </div>
        <div class="col-md-8 startVerification">
        	<h4>Choose document Type</h4>
        	<div class="dropdown">
			  <button class="btn cashRemit-btn1 dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			    Australian Drivers Licence
			     <span class="arrowDown"><img src="images/arrow-down.png"></span>
			  </button>
			  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
			    <li><a href="#">Australian Drivers Licence</a></li>
			    <li><a href="#">Australian Passport</a></li>
			    <li><a href="#">Australian Medicare Card</a></li>
			    <li><a href="#">International Passport</a></li>
			  </ul>
			</div>
         </div>
         <div class="col-md-4">
           <h4>Document Sample</h4>
             <div class="spacemen">
         	  <span><img src="images/WA.jpg"></span>
          </div>
        </div>
    </div>

    <div class="row">
    	<div class="col-md-12">
        <form class="form-horizontal" role="form">
          <fieldset>
            <legend style=" border-bottom: 1px solid #CCC;">Please enter you verification details</legend>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="card-holder-name">Licence Number</label>
                  <div class="col-sm-9 MainForm">
                     <input type="text" class="form-control" name="card-holder-name" id="card-holder-name" placeholder="Card Holder's Name">
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="expiry-month">Expiration Date :</label>
                <div class="col-sm-9 MainForm">
                    <div class="row">
                        <div class="col-xs-3 birthDay">
                         <span class="fa fa-caret-down"></span>
                            <select class="form-control col-sm-2" name="expiry-month" id="expiry-month">
                                <option>Month</option>
                                <option value="01">Jan (01)</option>
                                <option value="02">Feb (02)</option>
                                <option value="03">Mar (03)</option>
                                <option value="04">Apr (04)</option>
                                <option value="05">May (05)</option>
                                <option value="06">June (06)</option>
                                <option value="07">July (07)</option>
                                <option value="08">Aug (08)</option>
                                <option value="09">Sep (09)</option>
                                <option value="10">Oct (10)</option>
                                <option value="11">Nov (11)</option>
                                <option value="12">Dec (12)</option>
                            </select>
                        </div>
                        <div class="col-xs-3 birthMonth">
                          <span class="fa fa-caret-down"></span>
                            <select class="form-control" name="expiry-year">
                                <option value="13">2013</option>
                                <option value="14">2014</option>
                                <option value="15">2015</option>
                                <option value="16">2016</option>
                                <option value="17">2017</option>
                                <option value="18">2018</option>
                                <option value="19">2019</option>
                                <option value="20">2020</option>
                                <option value="21">2021</option>
                                <option value="22">2022</option>
                                <option value="23">2023</option>
                            </select>
                        </div>

                          <div class="col-xs-3 birthYear">
                           <span class="fa fa-caret-down"></span>
                             <select class="form-control" name="expiry-year">
                                <option value="13">2013</option>
                                <option value="14">2014</option>
                                <option value="15">2015</option>
                                <option value="16">2016</option>
                                <option value="17">2017</option>
                                <option value="18">2018</option>
                                <option value="19">2019</option>
                                <option value="20">2020</option>
                                <option value="21">2021</option>
                                <option value="22">2022</option>
                                <option value="23">2023</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="card-number">Flat/Unit No:</label>
                  <div class="col-sm-9 MainForm">
                    <input type="text" class="form-control" name="card-number" id="card-number" placeholder="Debit/Credit Card Number">
                </div>
            </div>
          
            <div class="form-group">
                <label class="col-sm-3 control-label" for="card-number">Bulilding No:</label>
                  <div class="col-sm-9 MainForm">
                    <input type="text" class="form-control" name="card-number" id="card-number" placeholder="Debit/Credit Card Number">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="card-number">Mobile Phone:</label>
                  <div class="col-sm-9 MainForm">
                    <input type="text" class="form-control" name="card-number" id="card-number" placeholder="Debit/Credit Card Number">
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 control-label" for="card-number">City or Suburb:</label>
                  <div class="col-sm-9 MainForm">
                    <input type="text" class="form-control" name="card-number" id="card-number" placeholder="Debit/Credit Card Number">
                </div>
            </div>
            
        </fieldset>
        <fieldset>
            <hr />
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="button" class="normal2-btn2 yellow-fil">Submit </button>
                </div>
            </div>
        </fieldset>
      </form>

    	</div>
    </div>
</div>