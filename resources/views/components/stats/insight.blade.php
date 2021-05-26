@props([
    // @TODO
])

{{--
    @TODO

    Size   | Light | Dark  |
    375px  |   x   |       |
    640px  |       |       |
    768px  |       |       |
    1024px |       |       |
    1280px |       |       |
    1920px |       |       |
--}}

<x-general.card with-border class="flex flex-col space-y-6 md:flex-row md:space-y-0 md:space-x-6">
    <div class="space-y-3 md:w-1/2">
        <h2 class="mb-0 text-sm font-semibold leading-none text-theme-secondary-900">
            {{--@TODO: link data--}}
            All-Time Transactions
        </h2>
        <p class="text-lg font-bold text-theme-secondary-900">
            {{--@TODO: link data--}}
            321,634,035
        </p>
    </div>

    <div class="border-t border-theme-secondary-300 pt-6 md:pt-0 md:border-t-0 md:w-1/2">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between">
            <div>
                <select class="-ml-1 text-sm font-semibold appearance-none text-theme-secondary-700">
                    {{--@TODO: styling and link data--}}
                    <option value="day">Day</option>
                    <option value="week" selected="selected">Week</option>
                    <option value="month">Month</option>
                    <option value="year">Year</option>
                    <option value="all-time">All-Time</option>
                </select>
                <h3 class="mt-4 mb-0 text-sm font-semibold leading-none text-theme-secondary-500">
                    {{--@TODO: link data--}}
                    Transactions
                </h3>
                <p class="mt-2 text-base font-semibold text-theme-secondary-700">
                    {{--@TODO: link data--}}
                    1,108,987
                </p>
            </div>

            <div class="mt-5 w-full sm:w-2/3">
                {{--@TODO: show chart and link data--}}

                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 244.768 45.47">
                    <defs>
                        <linearGradient id="linear-gradient" x1="0.5" x2="0.5" y2="1" gradientUnits="objectBoundingBox">
                            <stop offset="0" stop-color="#252f3e"/>
                            <stop offset="1" stop-color="#252f3e" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <g id="Group_516" data-name="Group 516" transform="translate(-1279.816 -4950.659)">
                        <path id="_2" data-name="2"
                              d="M419,1352.677c4.026,0,7.521,8.581,11.975,8.581s5.006-24.925,9.8-24.925,4.051,11.441,10.025,11.441h20.051c3.87,0,4.785-5.312,10.377-5.312s5.533,11.033,9.674,11.033,1.011,4.9,7.044,4.9h12.468c5.57,0,7.92-8.885,11.159-8.885s3.555-7.05,9.43-7.05,5.991,17.57,10.025,17.57,5.662-11.85,10.025-11.85,8.344-13.855,13.3-13.855c8.661,0,4.738,9.337,16.528,9.337s4.633,11.464,12.657,11.464,7.567-14.784,15.984-14.784,7.071,7.021,12.731,7.021h15.407c4.543,0,9.722-14.2,13.649-14.2s7.7-12.018,12.46-12.024v44.47H419Z"
                              transform="translate(860.816 3630.521)" opacity="0.25" fill="url(#linear-gradient)"/>
                        <path id="_2-2" data-name="2"
                              d="M420,1354.379c4.043,0,6.043,9.044,10.514,9.044s5.027-26.271,9.843-26.271,4.068,12.059,10.067,12.059h20.134c3.886,0,4.805-5.6,10.42-5.6s5.556,11.628,9.714,11.628,1.016,5.168,7.074,5.168h12.52c5.593,0,7.954-9.365,11.206-9.365s3.57-7.431,9.469-7.431,6.016,18.519,10.067,18.519,5.686-12.49,10.067-12.49,8.379-14.6,13.353-14.6c8.7,0,4.757,9.842,16.6,9.842s4.652,12.082,12.71,12.082,7.6-15.583,16.05-15.583,7.1,7.4,12.784,7.4H638.06c4.562,0,9.763-14.97,13.706-14.97s5.432-12.673,11-12.673"
                              transform="translate(860.816 3630.521)" fill="none" stroke="#252f3e" stroke-linecap="round"
                              stroke-width="2"/>
                    </g>
                </svg>

            </div>
        </div>
    </div>
</x-general.card>
