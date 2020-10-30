<!-- Accordion card -->
<div id="lefNav" >

	<div class="lBlockTitle p-0 pb-3 pt-3" role="tab" id="price">
	  <a data-toggle="collapse" data-parent="#accordionEx" href="#collapsePRICE" aria-expanded="true" aria-controls="collapsePRICE">
	    <h5 id="filterTitle" class="mb-0">
	       @lang('shop.title_price') {{--<i class="fas fa-angle-down rotate-icon"></i> --}}
	    </h5>
	  </a>
	</div>

	<div id="collapsePRICE" class="collapse show" role="tabpanel" aria-labelledby="price" data-parent="#accordionEx">


		<div class=" mb-2">
		    <input type="checkbox" name="price" class="form-check-input filled-in" id="price_1" value="0|1000" onclick='getVal()' {{ (in_array('0|1000', $searchREQ['price']))? 'checked':'' }}>
		    <label class="form-check-label" for="price_1">0 - 1.000 {{ setting('site.valuta') }}</label>
		</div>

		<div class=" mb-2">
		    <input type="checkbox" name="price" class="form-check-input filled-in" id="price_2" value="1000|2000" onclick='getVal()' {{ (in_array('1000|2000', $searchREQ['price']))? 'checked':'' }}>
		    <label class="form-check-label" for="price_2">1.000 - 2.000 {{ setting('site.valuta') }}</label>
		</div>

		<div class=" mb-2">
		    <input type="checkbox" name="price" class="form-check-input filled-in" id="price_3" value="2000|3000" onclick='getVal()' {{ (in_array('2000|3000', $searchREQ['price']))? 'checked':'' }}>
		    <label class="form-check-label" for="price_3">2.000 - 3.000 {{ setting('site.valuta') }}</label>
		</div>

		<div>
		    <input type="checkbox" name="price" class="form-check-input filled-in" id="price_4" value="3000|4000" onclick='getVal()' {{ (in_array('3000|4000', $searchREQ['price']))? 'checked':'' }}>
		    <label class="form-check-label" for="price_4">3.000 - 4.000 {{ setting('site.valuta') }}</label>
		</div>


	</div>


</div>