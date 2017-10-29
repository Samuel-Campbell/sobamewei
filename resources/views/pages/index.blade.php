@extends('layouts.default')
@section('content')

<script type="text/javascript" src="{{ URL::asset('js/index.js') }}"></script>

<div class="col-md-2">
    Categories
    <ul>
        <li><a href="/?eSType=Desktop">Desktop Computers</a></li>
        <li><a href="/?eSType=Laptop">Laptops</a></li>
        <li><a href="/?eSType=Monitor">Monitors</a></li>
        <li><a href="/?eSType=Tablet">Tablets</a></li>
    </ul>
    <?php $i = 1; ?>
    Price Range
    <ul>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="0-100"> $0 - $100</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="100-200"> $100 - $200</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="200-300"> $200 - $300</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="300-500"> $300 - $400</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="400-600"> $400 - $500</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="500-500"> $500 - $600</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="600-700"> $600 - $700</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="700-800"> $700 - $800</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="800-900"> $800 - $900</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="900-1000"> $900 - $1000</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="1000-1500"> $1000 - $1500</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="1500-2000"> $1500 - $2000</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="2000-3000"> $2000 - $3000</li>
        <li><input type="checkbox" name="priceRange" id="{{$i++}}" value="3000-2147483647"> More than $3000</li>
    </ul>

    @if($brandNames)
    Brand Names
    <ul>
        @foreach($brandNames as $brandName)
        <li><input type="checkbox" name="brandName" id="{{$i++}}" value="{{$brandName}}"> {{$brandName}}</li>
        @endforeach
    </ul>
    @endif

    @if($displaySizes)
    Display Sizes
    <ul>
        @foreach($displaySizes as $displaySize)
        <li><input type="checkbox" name="displaySize" id="{{$i++}}" value="{{$displaySize}}"> {{$displaySize}} inch</li>
        @endforeach
    </ul>
    @endif

    @if($hasTouchScreen)
    Option
    <ul>
        <li><input type="checkbox" name="touchScreen" id="{{$i++}}" value=1> TouchScreen</li>
    </ul>
    @endif

</div>



<div class="col-md-10">

    <div class="page-header">
        <div class="row">  
            <div class="col-md-8"><h2>
                    @if(isset($lastInputs['eSType']))
                    {{$lastInputs['eSType']}}
                    @else
                    All Electronics
                    @endif
                </h2></div> 

            <div class="col-md-2">
                <br/>
                <label class="control-label" for="sortBy">Sort by: </label>
                <select name="sortBy" onChange="window.location.href = this.value">

                    <?php
                    $stringWithoutSortBy = "";
                    foreach ($lastInputs as $key => $value) {
                        if ($key !== "sortBy") {
                            $stringWithoutSortBy .= $key . "=" . $value . "&";
                        }
                    }
                    ?>
                    <option value="/?{{$stringWithoutSortBy}}"{{!isset($lastInputs['sortBy'])? "selected" : "" }}>No order</option>
                    <option value="/?{{$stringWithoutSortBy}}sortBy=priceAscending"{{isset($lastInputs['sortBy']) && $lastInputs['sortBy'] === "priceAscending"? "selected" : "" }}>Ascending Price</option>
                    <option value="/?{{$stringWithoutSortBy}}sortBy=priceDescending"{{isset($lastInputs['sortBy']) && $lastInputs['sortBy'] === "priceDescending"? "selected" : "" }}>Descending Price</option>
                </select>
            </div>
        </div> 
    </div>


    @if (! empty($electronicSpecifications))
    @foreach ($electronicSpecifications as $eS)

    <div class="col-md-2">
        @if ( $eS->displaySize )
        {{$eS->displaySize}} inch 
        @endif
        @if ( $eS->brandName )
        {{$eS->brandName}}
        @endif
        @if ( $eS->ElectronicType_name )
        {{$eS->ElectronicType_name}}
        @endif
        <br/>
        @if ( $eS->modelNumber )
        Model {{$eS->modelNumber}}
        @endif
        <br/>
        @if ( $eS->price )
        Price: ${{$eS->price}}
        @endif
    </div>

    @endforeach
    @endif

</div>

@stop
