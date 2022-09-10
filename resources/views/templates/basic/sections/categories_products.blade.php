@forelse ($data as $k => $key)
            <!-- Featured Section Starts Here -->
	    <div class="featured-section padding-bottom-half padding-top-half oh">
	        <div class="container-fluid">
	            <div class="section-header-2">
	                <h3 class="title">{{ $key->name }}</h3>
	                <a href="{{route('products.category', ['id'=>$key->id, 'slug'=>slug($key->name)])}}" class="custom-button theme btn-sm">@lang('View All Products')</a>
	            </div>
	            <div class="m--15">
	                <div class="product-slider-2 owl-carousel owl-theme" style="display: block;">
	                	@if($key->products->count() > 0)
		                    @foreach ($key->products as $item)
		                    	@php $quantity = $item['stocks']->count() > 0 ? $item['stocks'][0]->quantity : 0 @endphp

		                        @if($quantity > 0)
		                            @php
		                                if($item->offer && $item->offer->activeOffer){
		                                    $discount = calculateDiscount($item->offer->activeOffer->amount, $item->offer->activeOffer->discount_type, $item->base_price);
		                                }else $discount = 0;
		                                $wCk = checkWishList($item->id);
		                                $cCk = checkCompareList($item->id);
		                            @endphp
		                            <div id="app-{{$index+1}}-{{$item->id}}" >   
		                                <div class="product-item-2">
		                                    <div class="product-item-2-inner wish-buttons-in">
												@if(isset($item->offer))
												@if($item->offer['activeOffer'])
                                                        @if($item->offer['activeOffer']['discount_type'] == 2)
                                                            <span class="text-white bg-danger tag-discount"> -{{$item->offer['activeOffer']['amount']}}% </span>
                                                        @else 
                                                            <span class="text-white bg-danger tag-discount"> -{{$item->offer['activeOffer']['amount']}}$ </span>
                                                        @endif
                                                @endif
												@endif
		                                        <div class="product-thumb ">
		                                            <a href="{{route('product.detail', ['id'=>$item->id, 'slug'=>slug($item->name)])}}">
		                                                <img src="{{ getImage(imagePath()['product']['path'].'/thumb_'.@$item->main_image, imagePath()['product']['size']) }}" alt="@lang('flash')">
		                                            </a>
		                                        </div>
		                                        <div style="display: none;" class="item-prod-argo badgeProduct{{$item->id}}"></div>
		                                        <div class="product-content">
	                                            <div class="product-before-content">
	                                                <h6 class="title">
	                                                    <a href="{{route('product.detail', ['id'=>$item->id, 'slug'=>slug($item->name)])}}">{{ __($item->name) }}</a>
	                                                </h6>
	                                            <div class="stock-argo">({{ $item['stocks']->count() > 0 ? $item['stocks'][0]->quantity : '0' }} @lang('product avaliable') )</div>
	                                                <div class="argo-tag-category">
	                                                    @if(isset($item['categories']) && ($item['categories']->count() > 0 ) ) 
	                                                    @foreach($item['categories'] as $category)
	                                                    <a href="{{ route('products.category', ['id'=>$category->id, 'slug'=>slug($category->name)]) }}">{{ __($category->name) }}</a>
	                                                    @if(!$loop->last)
	                                                    /
	                                                    @endif                                 
	                                                    @endforeach
	                                                    @else

	                                                    @endif
	                                                </div>
	                                                <div class="iva-argo">{{ $item->iva==1 ? 'Precio incluye IVA' : 'Exento'}}</div>
	                                                <!--    <div class="ratings-area justify-content-between">
	                                                <div class="ratings">
	                                                @php echo __(display_avg_rating($item->reviews)) @endphp
	                                                </div>
	                                                <span class="ml-2 mr-auto">({{ __($item->reviews->count()) }})</span>
	                                                <div class="price">
	                                                @if($discount > 0)
	                                                {{ $general->cur_sym }}{{ getAmount($item->precioBaseIva - $discount, 2) }}
	                                                <del>{{ getAmount($item->precioBaseIva, 2) }}</del>
	                                                @else
	                                                {{ $general->cur_sym }}{{ getAmount($item->precioBaseIva, 2) }}
	                                                @endif
	                                                </div>  -->
	                                </div>
	                                     </div>
										 	@php
												$rate = session()->get('rate');
												$moneda = session()->get('moneda');
											@endphp
		                                        <div class="product-argo">
		                                            <div class="price">
														@if($moneda=='Dolares' || $moneda == '')
															@if($discount > 0)
																{{ $general->cur_sym }}{{ getAmount($item->precioBaseIva - $discount, 2) }}
																<del>{{ getAmount($item->precioBaseIva, 2) }}</del>                                                  
																@if(!is_null($item->prime_price) )
																	<br>
																	Prime: {{ $general->cur_sym }}{{ getAmount($item->precioPrimeIva??$item->prime_price, 2) }}
																@endif                                              
															@else
																{{ $general->cur_sym }}{{ getAmount($item->precioBaseIva, 2) }}
																@if(!is_null($item->prime_price) )
																	<br>
																	Prime: {{ $general->cur_sym }}{{ getAmount($item->precioPrimeIva??$item->prime_price, 2) }}
																@endif  
															@endif
														@else 
															@if($discount > 0)
															{{ $moneda == 'Euros' ? '€. ' : 'Bs. ' }}{{ getAmount($item->precioBaseIva - $discount, 2) * $rate }}
																<del>{{ getAmount($item->precioBaseIva * $rate, 2) }}</del>                                                  
																@if(!is_null($item->prime_price) )
																	<br>
																	Prime: {{ $moneda == 'Euros' ? '€. ' : 'Bs. ' }}{{ getAmount($item->precioPrimeIva??$item->prime_price * $rate, 2) }}
																@endif                                              
															@else
															{{ $moneda == 'Euros' ? '€. ' : 'Bs. ' }}{{ getAmount($item->precioBaseIva * $rate, 2) }}
																@if(!is_null($item->prime_price) )
																	<br>
																	Prime: {{ $moneda == 'Euros' ? '€. ' : 'Bs. ' }}{{ getAmount($item->precioPrimeIva??$item->prime_price * $rate, 2) }}
																@endif  
															@endif
														@endif
		                                            </div>

		                                            <div class="argo-count">  
		                                                
		                                                <button @click="isShow = true" type="submit" class="cmn-btn-argo cart-add-btn showProduct{{ $item['id'] }}" data-id="{{ $item['id'] }}">@lang('Agregar')</button>

		                                                <div class="cart-plus-minus quantity">
		                                                    <div class="cart-decrease qtybutton dec">
		                                                        <i class="las la-minus"></i>
		                                                    </div>
		                                                    <select style="display: none;width: 80px;height: 40px;" 
		                                                    onchange="QuantityValue(this.value,'{{ $item->id }}')" 
		                                                    type="number" id="quantity{{ $item['id'] }}" name="quantity" step="1" min="1" class="integer-validation quantity{{ $item['id'] }} form-control">
		                                                        @if($quantity > 0)
		                                                            @for ($i = 1; $i < $quantity+1; $i++)
		                                                                <option value="{{$i}}">{{$i}}</option>
		                                                            @endfor
		                                                        @endif
		                                                    </select>
		                                                    <div class="cart-increase qtybutton inc">
		                                                        <i class="las la-plus"></i>
		                                                    </div>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                            </div>
		                        @endif
		                    @endforeach()
		                @endif
	    			</div>
				</div>
			</div>

		</div>
		@push('vue')
			<script>
			    var app3 = new Vue({
			        el: '#app-{{$index+1}}-{{$item->id}}',
			        data: {
			            BackTheme: null,
			            bagde: 1,
			            isHidden: true,
			            isShow: false
			        }
			    });
			</script>
		@endpush
		<script type="text/javascript">
			(function($){
			   	$(".owl-carousel").owlCarousel({
                items: 3,
                loop: !1,
                margin: 0,
                nav: !0,
                dots: !1,
					responsive: { 500: { items: 3 }, 768: { items: 3 }, 992: { items: 3 }, 1200: { items: 6 }, 1400: { items: 8 } }
				});
			   	triggerOwl();
			   	// getCartProduct();
			})(jQuery)


		</script>
        <!-- Featured Section Ends Here -->
@empty
	<h3 style="display: none;">Sin Productos</h3>
@endforelse           
