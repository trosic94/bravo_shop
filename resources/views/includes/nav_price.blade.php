<!-- Accordion card -->
<div id="lefNav" class="card">

	<div class="card-header p-0 pb-3 pt-3" role="tab" id="price">
	  <a data-toggle="collapse" data-parent="#accordionEx" href="#collapsePRICE" aria-expanded="true" aria-controls="collapsePRICE">
	    <h5 id="filterTitle" class="mb-0">
	      @lang('shop.title_price') <i class="fas fa-angle-down rotate-icon"></i>
	    </h5>
	  </a>
	</div>

	<div id="collapsePRICE" class="collapse show" role="tabpanel" aria-labelledby="price" data-parent="#accordionEx">
	  <div class="card-body p-0 pb-3 .text-annona-gray">

		<div class="form-check">
		    <input type="checkbox" name="price" class="form-check-input" id="price_1" value="1|300" onclick='getVal()' {{ (in_array('1|300', $searchREQ['price']))? 'checked':'' }}>
		    <label class="form-check-label" for="price_1">1 - 300 {{ setting('site.valuta') }}</label>
		</div>

		<div class="form-check">
		    <input type="checkbox" name="price" class="form-check-input" id="price_2" value="5001|10000" onclick='getVal()' {{ (in_array('5001|10000', $searchREQ['price']))? 'checked':'' }}>
		    <label class="form-check-label" for="price_2">5.001 - 10.000 {{ setting('site.valuta') }}</label>
		</div>

		<div class="form-check">
		    <input type="checkbox" name="price" class="form-check-input" id="price_3" value="10001|20000" onclick='getVal()' {{ (in_array('10001|20000', $searchREQ['price']))? 'checked':'' }}>
		    <label class="form-check-label" for="price_3">10.001 - 20.000 {{ setting('site.valuta') }}</label>
		</div>

		<div class="form-check">
		    <input type="checkbox" name="price" class="form-check-input" id="price_4" value="20001|30000" onclick='getVal()' {{ (in_array('20001|30000', $searchREQ['price']))? 'checked':'' }}>
		    <label class="form-check-label" for="price_4">20.001 - 30.000 {{ setting('site.valuta') }}</label>
		</div>

		<div class="form-check">
		    <input type="checkbox" name="price" class="form-check-input" id="price_5" value="30001|40000" onclick='getVal()' {{ (in_array('30001|40000', $searchREQ['price']))? 'checked':'' }}>
		    <label class="form-check-label" for="price_5">30.001 - 40.000 {{ setting('site.valuta') }}</label>
		</div>

		<div class="form-check">
		    <input type="checkbox" name="price" class="form-check-input" id="price_6" value="40001|50000" onclick='getVal()' {{ (in_array('40001|50000', $searchREQ['price']))? 'checked':'' }}>
		    <label class="form-check-label" for="price_6">40.001 - 50.000 {{ setting('site.valuta') }}</label>
		</div>

	  </div>
	</div>


</div>