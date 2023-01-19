@foreach($getDetail as $key=>$getDetails)
<div class="col-12 design_outter_comman border mb-4">
  <div class="row comman_header justify-content-between">
    <div class="col">
      <h2>Packing List {{$key+1}}</h2>
    </div>
    <div class="col-auto"></div>
  </div>
  <div class="row py-4 px-3 align-items-center">
    <div class="col">
      <div class="row">
        <div class="col-12 Packing_data mb-3">
          <span>Name : <strong>{{$getDetails->name}}</strong>
          </span>
        </div>
        <div class="col-12 Packing_data">
          <span>Mobile No. : <strong>{{$getDetails->mobile}}</strong>
          </span>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="row">
        <div class="col-12 Packing_data mb-3">
          <span>Date : <strong>23/05/2022</strong>
          </span>
        </div>
        <div class="col-12 Packing_data">
          <span>User Id : <strong>{{$getDetails->id}}</strong>
          </span>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="row">
        <div class="col-12">
        <!-- {!! QrCode::size(100)->generate('hi') !!} -->
          <img class="qr_code" src="{{ asset('storage/'.$getDetails->image)}}" alt="">
        </div>
      </div>
    </div>
    <div class="col">
      <div class="row">
        <div class="col-12 Packing_data mb-3">
          <span>Driver : <strong>Mustafa</strong>
          </span>
        </div>
        <div class="col-12 Packing_data">
          <span>Address : <strong>{{$getDetails->area}}</strong>
          </span>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="row">
        <div class="col-12 Packing_data mb-3">
          <span>Plan Expiry Date : <strong>28/06/2022</strong>
          </span>
        </div>
        <div class="col-12 Packing_data">
          <span>Time Slot : <strong>{{$getDetails->delieverySlot->name}}({{$getDetails->delieverySlot->start_time}}-{{$getDetails->delieverySlot->end_time}})</strong>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 comman_table_design border bg-white px-0">
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>Name of Meal</th>
              <th>Diet Plan</th>
              <th>Category</th>
              <th>Portion</th>
              <th>Cal</th>
              <th>Pro</th>
              <th>Carb</th>
              <th>Fat</th>
            </tr>
          </thead>
          <tbody>
            @foreach($getDetails->getMeal as $v=>$getMeals)
            <tr>
              <td>{{$getMeals->name}}</td>
              <td>-</td>
              <td>-</td>
              <td>{{$getMeals->size_pcs}}</td>
              <td>{{$getMeals->meal_calorie}}</td>
              <td>{{$getMeals->protein}}</td>
              <td>{{$getMeals->carbs}}</td>
              <td>{{$getMeals->fat}}</td>
            </tr>
            @endforeach
            <tr>
              <td></td>
              <td></td>
              <td>
                <strong>*Recommmended Calorie: {{$getDetails->getCalorie->recommended}}</strong>
              </td>
              <td>
                <strong>Total</strong>
              </td>
              <td>
                <strong> {{$calories}}</strong>
              </td>
              <td>
                <strong>{{$proteins}}</strong>
              </td>
              <td>
                <strong>{{$carbss}}</strong>
              </td>
              <td>
                <strong>{{$fats}}</strong>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endforeach