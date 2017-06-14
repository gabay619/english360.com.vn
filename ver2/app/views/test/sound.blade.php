@extends('layouts.private_not_aside', array(
    'breadcrumb'=>'Kiểm tra trình độ',
    'breadcrumbUrl' => '/test'
))
@section('content')
    <script src='https://code.responsivevoice.org/responsivevoice.js'></script>
    <div class="main">
        <div class="content_cate p5">
            <div class="item_cate">
                <div class="content_items">
                    <div class="content_item dangky_view content_dangky">
                        <div class="row">
                            <div id="qArea" class="col-sm-8">
                                <div class="title_bt">1. <a class="listen" href="javascript:void(0)">Excuse me! Where’s the post office?</a></div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">Don't worry</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">B. <a class="listen" href="javascript:void(0)">At the end of this road</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">Yes, I think so</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">I'm afraid not</a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button id="btnNext" onclick="toNext()" class="btn btn-danger">Next <i class="fa fa-play"></i> </button>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                        <div id="txtAns" style="display: none; border: 1px solid red; padding: 5px">
                        </div>
                        <div style="text-align: center; margin-top: 10px">
                            <button id="btnStart" onclick="startRecord()" class="btn btn-primary btn-lg"><i class="fa fa-2x fa-microphone"></i></button>
                            <p id="speakerMss"></p>
                        </div>
                        <div class="qBox" style="display: none">
                            <div>
                                <div class="title_bt">2. <a class="listen" href="javascript:void(0)">What shall we do this evening?</a></div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">No problem</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">B. <a class="listen" href="javascript:void(0)">Let's go out for dinner</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">Oh, that's good!</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)"> I went out for dinner</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">3. <a class="listen" href="javascript:void(0)">Where do you come from?</a></div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">In London</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">Yes, I have just come here</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">I’m not</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">D. <a class="listen" href="javascript:void(0)">I come from London.</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">4. <a class="listen" href="javascript:void(0)">Bye</a></div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">See you lately.</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">Thank you.</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">Meet you again</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">D. <a class="listen" href="javascript:void(0)">See you later.</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">5. <a class="listen" href="javascript:void(0)">Hello. Nice to meet you.</a></div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">Good bye.</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">Thank you.</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">C. <a class="listen" href="javascript:void(0)">Nice to meet you too.</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">No problem</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">6. <a class="listen" href="javascript:void(0)">I’m taking my end-of-term examination tomorrow.</a></div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">Good day </a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">Good chance</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">Good time</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">D. <a class="listen" href="javascript:void(0)">Good luck</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">7. <a class="listen" href="javascript:void(0)">Are you going to visit Britain next month?</a></div>
                                <div class="listAns">
                                    <div>
                                        <span class="trueAns">A. <a class="listen" href="javascript:void(0)">Yes, I am </a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">Yes, I can </a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">Yes, I like</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">Yes, I do</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">8. <a class="listen" href="javascript:void(0)">You’ve got a beautiful dress!</a></div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)"> I do</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">Okay</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">You, too</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">D. <a class="listen" href="javascript:void(0)">Thank you</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">9. <a class="listen" href="javascript:void(0)">Happy Christmas!</a></div>
                                <div class="listAns">
                                    <div>
                                        <span class="trueAns">A. <a class="listen" href="javascript:void(0)">The same to you!</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">Happy Christmas with you!</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">You are the same!</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">Same for you!</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">10. <a class="listen" href="javascript:void(0)">You look nice today. I like your new hair style.</a></div>
                                <div class="listAns">
                                    <div>
                                        <span class="trueAns">A. <a class="listen" href="javascript:void(0)">It’s nice of you to say so.</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">You're so mean</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">Oh, well done.</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)"> I feel interesting to hear that.</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">11. .....? – <a class="listen" href="javascript:void(0)">He's tall and thin with blue eyes.</a></div>
                                <div class="listAns">
                                    <div>
                                        <span class="trueAns">A. <a class="listen" href="javascript:void(0)">What does John look like ?</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">Who does John look like ?</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">What does John like?</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">How is John doing?</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">12.  .....? – <a class="listen" href="javascript:void(0)">I have got a terrible headache.</a></div>
                                <div class="listAns">
                                    <div>
                                        <span class="trueAns">A. <a class="listen" href="javascript:void(0)">What’s the matter with you?</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">What’s the wrong with you?</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">What's happening?</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">What’s problem with you?</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">13. <a class="listen" href="javascript:void(0)">Thanks for the lovely evening.</a></div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">Cheers</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">Thanks</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">Have a good day</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">D. <a class="listen" href="javascript:void(0)">You are welcome</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">14. <a class="listen" href="javascript:void(0)"> When your boss tells you: “Don’t drop the ball on this one”, he means:</a></div>
                                <div class="listAns">
                                    <div>
                                        <span class="trueAns">A. <a class="listen" href="javascript:void(0)">Don’t make a mistake.</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">Don’t miss the deadline.</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">Be creative.</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">Don't try to solve everything by yourself.</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">15. <a class="listen" href="javascript:void(0)">You think that you cannot meet the given deadline. What do you say to your boss?</a></div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">Could you delete my deadline?</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">Can you call off my deadline?</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">Can you lengthen my deadline?</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">D. <a class="listen" href="javascript:void(0)">Could you extend my deadline?</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">16. <a class="listen" href="javascript:void(0)">"Oh, it's you. I ..... you." - "I've just had my hair cut.</a></div>
                                <div class="listAns">
                                    <div>
                                        <span class="trueAns">A. <a class="listen" href="javascript:void(0)">can't recognize</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">not recognized</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">recognized</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">will recognize</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">17. <a class="listen" href="javascript:void(0)">Do you mind ..... ?</a></div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">me to close the window</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">mine closing the window</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">C. <a class="listen" href="javascript:void(0)">if I closed the window</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)"> if I would close the window</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">18. <a class="listen" href="javascript:void(0)">"Let's go camping."</a> - ".....". <a class="listen" href="javascript:void(0)">The weather is terrible.</a></div>
                                <div class="listAns">
                                    <div>
                                        <span class="trueAns">A. <a class="listen" href="javascript:void(0)">I don't think it's a good idea.</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)"> Just bring yourselves.</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">Yes, let's do that.</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">No problem</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">19. Jane: <a class="listen" href="javascript:void(0)">"Where are you going?"</a> -
                                    Maria: "..... <a class="listen" href="javascript:void(0)">post office."</a></div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">I'm going to </a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">  I have to go</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">To</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">D. <a class="listen" href="javascript:void(0)">I'm going to the</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">20. Jack: " ..... <a class="listen" href="javascript:void(0)">to pay by credit card or with cash?" </a> -
                                    Carol: <a class="listen" href="javascript:void(0)">"Cash please."</a></div>
                                <div class="listAns">
                                    <div>
                                        <span class="trueAns">A. <a class="listen" href="javascript:void(0)"> Would you like</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)"> What do you want</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">What would you like to pay</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">Which do you want</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">21. Ellen: <a class="listen" href="javascript:void(0)">"What is your job?"</a> -
                                    Peter: "..... , <a class="listen" href="javascript:void(0)">I study English at Hanoi University."</a></div>
                                <div class="listAns">
                                    <div>
                                        <span class="trueAns">A. <a class="listen" href="javascript:void(0)">I’m a student</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)"> Student</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)"> I’m a learner</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">I'm a worker</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">
                                    22. Linda: "..... <a class="listen" href="javascript:void(0)">are you going to the meeting this morning?"</a> -
                                    Carl: <a class="listen" href="javascript:void(0)">"I’m going at 10:30."</a>
                                </div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">When</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">B. <a class="listen" href="javascript:void(0)"> What time</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">What is the time</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">How</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">
                                    23. <a class="listen" href="javascript:void(0)">Well Mary, .....  winning the Accountant of the Year award.</a>
                                </div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">Congratulation on</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">B. <a class="listen" href="javascript:void(0)"> Congratulations on</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">Congratulation in</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">Congratulations in</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">
                                    24. <a class="listen" href="javascript:void(0)">Sunflower Company. Good morning . ..... I help you?</a>
                                </div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">Can</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)"> Could</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">C. <a class="listen" href="javascript:void(0)">May</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">Might</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">
                                    25. David: <a class="listen" href="javascript:void(0)">"What time will you come back?"</a> -
                                    Alesha: "..... <a class="listen" href="javascript:void(0)">at 3:30</a>."
                                </div>
                                <div class="listAns">
                                    <div>
                                        <span class="trueAns">A. <a class="listen" href="javascript:void(0)"> I will be back</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">  I will back</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)">I am back</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">I am come back</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">
                                    26. Simon: <a class="listen" href="javascript:void(0)">"David, It's good to see you, how have you been?"</a> -
                                    David: "...... <a class="listen" href="javascript:void(0)">How about you?"</a>
                                </div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)"> It's good to see you</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)"> I'm so busy</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)"> I'm so cold</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">D. <a class="listen" href="javascript:void(0)"> I've been busy</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">
                                    27. Jane: <a class="listen" href="javascript:void(0)">"Hello. Could I speak to Mr. Chang, please?"</a> -
                                    Amanda: "..... <a class="listen" href="javascript:void(0)">who's calling?"</a>
                                </div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">Sorry</a></span>
                                    </div>
                                    <div>
                                        <span>B. <a class="listen" href="javascript:void(0)">  I want to know</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">C. <a class="listen" href="javascript:void(0)"> May I ask</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)">  I want to ask</a></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title_bt">
                                    28. <a class="listen" href="javascript:void(0)">Linda, could you come ..... my office and show Mary around please?</a>
                                </div>
                                <div class="listAns">
                                    <div>
                                        <span>A. <a class="listen" href="javascript:void(0)">In</a></span>
                                    </div>
                                    <div>
                                        <span class="trueAns">B. <a class="listen" href="javascript:void(0)"> To</a></span>
                                    </div>
                                    <div>
                                        <span>C. <a class="listen" href="javascript:void(0)"> Into</a></span>
                                    </div>
                                    <div>
                                        <span>D. <a class="listen" href="javascript:void(0)"> At</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <script>
        var index = 0;
        $(function(){
            $('#qArea').on('click','.listen',function () {
                responsiveVoice.speak($(this).html())
            })
        });

        function checkPhrase(ph1,ph2){
            return ph1.toLowerCase().replace(/[^a-zA-Z1-9]/g, "") == ph2.toLowerCase().replace(/[^a-zA-Z1-9]/g, "");
        }

        function toNext() {
//            $('#btnNext').hide();
            $('#txtAns').hide();
            if(index==27){
                $('#btnNext').hide();
                return false;
            }
            htmlx = $('.qBox >div').eq(index).html();
            $('#qArea').html(htmlx);
            index = parseInt(index)+1;

            $('#btnStart').show();
        }

        function checkAns(ans) {
            match = false;
            $('#qArea .listAns span a').each(function () {
                if(checkPhrase($(this).html(),ans)){
                    if($(this).parent().attr('class')=='trueAns'){
                        $(this).parent().append('<i class="i_anw_true"></i>');
                        $(this).addClass('text-success')
                    }
                    else{
                        $(this).parent().append('<i class="i_anw_false"></i>');
                        $(this).addClass('text-danger');
                    }
//                    $('#btnNext').show();
                    $('#btnStart').hide();
                    match = true;
                }
            });
            if(!match)
                $('#txtAns').show().html(ans);

        }
        var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
        var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList;
        var SpeechRecognitionEvent = SpeechRecognitionEvent || webkitSpeechRecognitionEvent;
        var recognition = new SpeechRecognition();
        var speechRecognitionList = new SpeechGrammarList();
        //    speechRecognitionList.addFromString(grammar, 1);
        //    recognition.grammars = speechRecognitionList;
        //recognition.continuous = false;
        recognition.lang = 'en-US';
        //    recognition.interimResults = false;
        //    recognition.maxAlternatives = 1;
        startRecord = function() {
            recognition.start();
            $('#txtAns').hide();
            $('#btnStart').removeClass('btn-primary').addClass('btn-success');
            $('#speakerMss').html('Nói vào micro...')
        }
        recognition.onresult = function(event) {
            // The SpeechRecognitionEvent results property returns a SpeechRecognitionResultList object
            // The SpeechRecognitionResultList object contains SpeechRecognitionResult objects.
            // It has a getter so it can be accessed like an array
            // The [last] returns the SpeechRecognitionResult at the last position.
            // Each SpeechRecognitionResult object contains SpeechRecognitionAlternative objects that contain individual results.
            // These also have getters so they can be accessed like arrays.
            // The [0] returns the SpeechRecognitionAlternative at position 0.
            // We then return the transcript property of the SpeechRecognitionAlternative object
            var last = event.results.length - 1;
            ans = event.results[last][0].transcript;
            checkAns(ans);
//        if(ans) checkAns(ans);
//        else{
//            $('#txtAns').show().html('Không bắt được âm thanh');
//            $('#btnStart').html('<i class="fa fa-2x fa-volume-off"></i>');
//        }
        }

        recognition.onspeechend = function() {
            recognition.stop();
            $('#btnStart').removeClass('btn-success').addClass('btn-primary');
            $('#speakerMss').html('')
        }

        recognition.onnomatch = function(event) {
            $('#txtAns').show().html('Không bắt được âm thanh');
            $('#btnStart').removeClass('btn-success').addClass('btn-primary');
            $('#speakerMss').html('')
//            diagnostic.textContent = "I didn't recognise that color.";
        }

        recognition.onerror = function(event) {
            $('#txtAns').show().html(event.error);
            $('#btnStart').removeClass('btn-success').addClass('btn-primary');
            $('#speakerMss').html('')
//        alert(event.error);
        }
    </script>
@endsection