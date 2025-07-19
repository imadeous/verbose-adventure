<section
    x-data="quoteForm()"
    class="text-gray-400 bg-gray-900 body-font">
    <!-- Removed fallbackQuoteForm: only the main form is present -->
    <div class="container px-5 mt-24 mx-auto flex flex-wrap flex-col">
        <!-- Step Tabs -->
        <div class="flex mx-auto flex-wrap mb-20">
            <template x-for="(tab, idx) in tabs" :key="idx">
                <a
                    :class="[
                        'sm:px-6 py-3 w-1/2 sm:w-auto justify-center sm:justify-start border-b-2 title-font font-medium inline-flex items-center leading-none tracking-wider rounded-t',
                        step === idx ? 'bg-gray-800 border-yellow-500 text-white' : 'border-gray-800 hover:text-white'
                    ]"
                    href="javascript:void(0)"
                    @click="step = idx">
                    <template x-if="tab.icon === 'user'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </template>
                    <template x-if="tab.icon === 'order'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                        </svg>
                    </template>
                    <template x-if="tab.icon === 'services'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.39 48.39 0 0 1-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 0 1-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 0 0-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 0 1-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 0 0 .657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 0 1-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 0 0 5.427-.63 48.05 48.05 0 0 0 .582-4.717.532.532 0 0 0-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 0 0 .658-.663 48.422 48.422 0 0 0-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 0 1-.61-.58v0Z" />
                        </svg>
                    </template>
                    <template x-if="tab.icon === 'review'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                    </template>
                    <span x-text="tab.label"></span>
                </a>
            </template>
        </div>
    </div>
    <div class="container px-5 mx-auto">
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <!-- Step 1: Customer Information -->
            <!-- All visible fields moved inside the form below -->
            <!-- Step 2: Order Specifics -->
            <!-- All visible fields moved inside the form below -->
            <!-- Step 3: Additional Services -->
            <!-- All visible fields moved inside the form below -->
            <!-- Step 4: Review & Send -->
            <!-- Review step remains outside the form, as it is display-only -->
            <!-- Navigation Buttons -->

            <div class="p-2 w-full flex justify-between items-center mt-6">
                <form id="quoteForm" method="POST" action="/quote" enctype="multipart/form-data" autocomplete="off">
                    <!-- Step 1: Customer Information -->
                    <div x-show="step === 0" x-transition>
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-full md:w-1/2">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-400">Name*</label>
                                    <input type="text" id="name" name="name" x-model="form.name" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full md:w-1/2">
                                <div class="relative">
                                    <label for="email" class="leading-7 text-sm text-gray-400">Email*</label>
                                    <input type="email" id="email" name="email" x-model="form.email" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full md:w-1/2">
                                <div class="relative">
                                    <label for="phone" class="leading-7 text-sm text-gray-400">Phone Number*</label>
                                    <input type="text" id="phone" name="phone" x-model="form.phone" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full md:w-1/2">
                                <div class="relative">
                                    <label for="instagram" class="leading-7 text-sm text-gray-400">Instagram Username (Optional)</label>
                                    <input type="text" id="instagram" name="instagram" x-model="form.instagram" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="delivery_address" class="leading-7 text-sm text-gray-400">Delivery Address*</label>
                                    <textarea id="delivery_address" name="delivery_address" x-model="form.delivery_address" rows="3" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out" placeholder="Enter your delivery address"></textarea>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="billing_address" class="leading-7 text-sm text-gray-400">Billing Address (Optional)</label>
                                    <textarea id="billing_address" name="billing_address" x-model="form.billing_address" rows="3" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out" placeholder="Enter your billing address if different"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Step 2: Order Specifics -->
                    <div x-show="step === 1" x-transition>
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-full md:w-1/2">
                                <div class="relative">
                                    <label for="product_type" class="leading-7 text-sm text-gray-400">Product Type*</label>
                                    <select id="product_type" name="product_type" x-model="form.product_type" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <option value="" disabled>Select a product</option>
                                        <option value="prototype">Prototype Model</option>
                                        <option value="figurine">Custom Figurine</option>
                                        <option value="replacement_part">Replacement Part</option>
                                        <option value="miniature">Miniature</option>
                                        <option value="custom_design">Custom Design (Please Describe)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="p-2 w-full md:w-1/2">
                                <div class="relative">
                                    <label for="material" class="leading-7 text-sm text-gray-400">Preferred Material (Optional)</label>
                                    <select id="material" name="material" x-model="form.material" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <option value="">Any</option>
                                        <option value="pla">PLA</option>
                                        <option value="petg">PETG</option>
                                        <option value="abs">ABS</option>
                                        <option value="eco_pla">ECO-PLA</option>
                                        <option value="mixed">Mixed Materials</option>
                                    </select>
                                </div>
                            </div>
                            <div class="p-2 w-full md:w-1/2">
                                <div class="relative">
                                    <label for="quantity" class="leading-7 text-sm text-gray-400">Quantity*</label>
                                    <select id="quantity" name="quantity" x-model="form.quantity" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <option value="" disabled>Select quantity</option>
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                        <option value="10+">10+</option>
                                    </select>
                                </div>
                            </div>
                            <div class="p-2 w-full md:w-1/2">
                                <div class="relative">
                                    <label for="timeline" class="leading-7 text-sm text-gray-400">Timeline*</label>
                                    <select id="timeline" name="timeline" x-model="form.timeline" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <option value="" disabled>Select timeline</option>
                                        <option value="1-2 weeks">1-2 weeks</option>
                                        <option value="2-4 weeks">2-4 weeks</option>
                                        <option value="1-2 months">1-2 months</option>
                                        <option value="flexible">Flexible</option>
                                    </select>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="description" class="leading-7 text-sm text-gray-400">Project Description</label>
                                    <textarea id="description" name="description" x-model="form.description" rows="4" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out" placeholder="Describe your project, dimensions, style, etc."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Step 3: Additional Services -->
                    <div x-show="step === 2" x-transition>
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-full">
                                <label class="leading-7 text-sm text-gray-400 block mb-2">Additional Services</label>
                                <div class="flex flex-col gap-3">
                                    <label class="flex items-center justify-between bg-gray-800 bg-opacity-40 rounded px-3 py-2 border border-gray-700">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="services[]" value="design_consultation" x-model="form.services" class="form-checkbox text-yellow-500 mr-2">
                                            <span class="text-gray-100">Design Consultation</span>
                                        </div>
                                        <span class="text-yellow-400 text-xs ml-2">+MVR 50/hour</span>
                                    </label>
                                    <label class="flex items-center justify-between bg-gray-800 bg-opacity-40 rounded px-3 py-2 border border-gray-700">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="services[]" value="post_processing" x-model="form.services" class="form-checkbox text-yellow-500 mr-2">
                                            <span class="text-gray-100">Post-processing & Finishing</span>
                                        </div>
                                        <span class="text-yellow-400 text-xs ml-2">+MVR 7,500</span>
                                    </label>
                                    <label class="flex items-center justify-between bg-gray-800 bg-opacity-40 rounded px-3 py-2 border border-gray-700">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="services[]" value="assembly" x-model="form.services" class="form-checkbox text-yellow-500 mr-2">
                                            <span class="text-gray-100">Assembly</span>
                                        </div>
                                        <span class="text-yellow-400 text-xs ml-2">+MVR 50/hour</span>
                                    </label>
                                    <label class="flex items-center justify-between bg-gray-800 bg-opacity-40 rounded px-3 py-2 border border-gray-700">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="services[]" value="rush_delivery" x-model="form.services" class="form-checkbox text-yellow-500 mr-2">
                                            <span class="text-gray-100">Rush Delivery (24 hours)</span>
                                        </div>
                                        <span class="text-yellow-400 text-xs ml-2">+20%</span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-2 w-full md:w-1/2">
                                <div class="relative">
                                    <label for="budget" class="leading-7 text-sm text-gray-400">Budget Range (Optional)</label>
                                    <select id="budget" name="budget" x-model="form.budget" class="w-full bg-gray-800 bg-opacity-40 rounded border border-gray-700 focus:border-yellow-500 focus:bg-gray-900 focus:ring-2 focus:ring-yellow-900 text-base outline-none text-gray-100 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <option value="">No preference</option>
                                        <option value="under_50k">Under MVR 500</option>
                                        <option value="50k_100k">MVR 500 - MVR 1,000</option>
                                        <option value="100k_250k">MVR 1,000 - MVR 2,500</option>
                                        <option value="250k_500k">MVR 2,500 - MVR 5,000</option>
                                        <option value="over_500k">Over MVR 5,000</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Hidden real form fields for PHP POST -->
                    <input type="hidden" name="name" id="hidden_name">
                    <input type="hidden" name="email" id="hidden_email">
                    <input type="hidden" name="phone" id="hidden_phone">
                    <input type="hidden" name="instagram" id="hidden_instagram">
                    <input type="hidden" name="delivery_address" id="hidden_delivery_address">
                    <input type="hidden" name="billing_address" id="hidden_billing_address">
                    <input type="hidden" name="product_type" id="hidden_product_type">
                    <input type="hidden" name="material" id="hidden_material">
                    <input type="hidden" name="quantity" id="hidden_quantity">
                    <input type="hidden" name="timeline" id="hidden_timeline">
                    <input type="hidden" name="description" id="hidden_description">
                    <input type="hidden" name="budget" id="hidden_budget">
                    <div id="hidden_services"></div>
                    <button
                        x-show="step > 0"
                        @click="step--"
                        type="button"
                        class="flex mx-auto text-white bg-gray-600 border-0 py-2 px-8 focus:outline-none hover:bg-gray-700 rounded text-lg">Previous</button>
                    <button
                        x-show="step < tabs.length - 1"
                        @click="nextStep"
                        type="button"
                        class="flex mx-auto text-white bg-yellow-500 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-600 rounded text-lg">Next</button>
                    <template x-if="step === tabs.length - 1">
                        <div class="flex mx-auto">
                            <button
                                x-show="isFormValid()"
                                type="submit"
                                class="text-white bg-yellow-500 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-600 rounded text-lg transition-all duration-200">
                                Submit
                            </button>
                            <div
                                x-show="!isFormValid()"
                                class="flex items-center justify-center h-12 px-8 bg-gray-700 rounded text-lg text-gray-300 ml-0"
                                style="min-width: 100px;">
                                <span>Validating</span>
                                <span class="ml-2 flex space-x-1">
                                    <span class="dot bg-yellow-400 rounded-full w-2 h-2 inline-block animate-bounce" style="animation-delay:0s"></span>
                                    <span class="dot bg-yellow-400 rounded-full w-2 h-2 inline-block animate-bounce" style="animation-delay:0.2s"></span>
                                    <span class="dot bg-yellow-400 rounded-full w-2 h-2 inline-block animate-bounce" style="animation-delay:0.4s"></span>
                                </span>
                            </div>
                        </div>
                    </template>
                    <style>
                        @keyframes bounce {

                            0%,
                            80%,
                            100% {
                                transform: scale(1);
                            }

                            40% {
                                transform: scale(1.5);
                            }
                        }

                        .animate-bounce {
                            animation: bounce 1s infinite;
                        }
                    </style>
                </form>
                <script>
                    // Sync visible fields to hidden fields in real time and before submit
                    function syncHiddenFieldsFromForm(form) {
                        document.getElementById('hidden_name').value = form.name.value;
                        document.getElementById('hidden_email').value = form.email.value;
                        document.getElementById('hidden_phone').value = form.phone.value;
                        document.getElementById('hidden_instagram').value = form.instagram.value;
                        document.getElementById('hidden_delivery_address').value = form.delivery_address.value;
                        document.getElementById('hidden_billing_address').value = form.billing_address.value;
                        document.getElementById('hidden_product_type').value = form.product_type.value;
                        document.getElementById('hidden_material').value = form.material.value;
                        document.getElementById('hidden_quantity').value = form.quantity.value;
                        document.getElementById('hidden_timeline').value = form.timeline.value;
                        document.getElementById('hidden_description').value = form.description.value;
                        document.getElementById('hidden_budget').value = form.budget.value;
                        // Services[]
                        const servicesDiv = document.getElementById('hidden_services');
                        servicesDiv.innerHTML = '';
                        const checkedServices = form.querySelectorAll('input[name="services[]"]:checked');
                        checkedServices.forEach(input => {
                            const hidden = document.createElement('input');
                            hidden.type = 'hidden';
                            hidden.name = 'services[]';
                            hidden.value = input.value;
                            servicesDiv.appendChild(hidden);
                        });
                    }
                    document.addEventListener('DOMContentLoaded', function() {
                        const form = document.getElementById('quoteForm');
                        // Sync on input/change
                        form.addEventListener('input', function() {
                            syncHiddenFieldsFromForm(form);
                        });
                        form.addEventListener('change', function() {
                            syncHiddenFieldsFromForm(form);
                        });
                        // Sync before submit
                        form.addEventListener('submit', function(e) {
                            syncHiddenFieldsFromForm(form);
                        });
                        // Initial sync
                        syncHiddenFieldsFromForm(form);
                    });
                </script>
            </div>
        </div>
    </div>
</section>

<script>
    function quoteForm() {
        return {
            step: 0,
            tabs: [{
                    label: 'CUSTOMER DETAILS',
                    icon: 'user'
                },
                {
                    label: 'ORDER SPECIFICS',
                    icon: 'order'
                },
                {
                    label: 'ADDITONAL SERVICES',
                    icon: 'services'
                },
                {
                    label: 'REVIEW & SEND',
                    icon: 'review'
                }
            ],
            form: {
                name: '',
                email: '',
                phone: '',
                instagram: '',
                delivery_address: '',
                billing_address: '',
                product_type: '',
                material: '',
                quantity: '',
                timeline: '',
                description: '',
                services: [],
                budget: ''
            },
            nextStep() {
                if (this.step < this.tabs.length - 1) this.step++;
            },
            prevStep() {
                if (this.step > 0) this.step--;
            },
            isFormValid() {
                // Helper to check all required fields
                const requiredFields = [
                    'name',
                    'email',
                    'phone',
                    'delivery_address',
                    'product_type',
                    'quantity',
                    'timeline'
                ];
                for (const field of requiredFields) {
                    const val = this.form[field];
                    if (typeof val === 'string') {
                        if (!val.trim()) return false;
                    } else if (val === null || val === undefined || val === '') {
                        return false;
                    }
                }
                return true;
            },
            productTypeLabel(val) {
                const map = {
                    prototype: 'Prototype Model',
                    figurine: 'Custom Figurine',
                    replacement_part: 'Replacement Part',
                    miniature: 'Miniature',
                    custom_design: 'Custom Design',
                };
                return map[val] || '-';
            },
            materialLabel(val) {
                const map = {
                    pla: 'PLA',
                    petg: 'PETG',
                    abs: 'ABS',
                    eco_pla: 'ECO-PLA',
                    mixed: 'Mixed Materials',
                    '': 'Any'
                };
                return map[val] || 'Any';
            },
            serviceLabel(val) {
                const map = {
                    design_consultation: 'Design Consultation',
                    post_processing: 'Post-processing & Finishing',
                    assembly: 'Assembly',
                    rush_delivery: 'Rush Delivery (24 hours)'
                };
                return map[val] || val;
            },
            servicePrice(val) {
                const map = {
                    design_consultation: '+₦50/hour',
                    post_processing: '+₦7,500',
                    assembly: '+₦50/hour',
                    rush_delivery: '+50%'
                };
                return map[val] || '';
            },
            budgetLabel(val) {
                const map = {
                    under_50k: 'Under ₦50,000',
                    '50k_100k': '₦50,000 - ₦100,000',
                    '100k_250k': '₦100,000 - ₦250,000',
                    '250k_500k': '₦250,000 - ₦500,000',
                    over_500k: 'Over ₦500,000',
                    '': 'No preference'
                };
                return map[val] || 'No preference';
            }
        }
    }
</script>