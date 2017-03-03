package com.skel.game.android;

import android.content.Context;
import android.speech.tts.*;

import java.util.Locale;

/**
 * Created by manuel on 22/01/17.
 */

public class AndroidHintSpeech implements com.skel.util.HintSpeech{

    private TextToSpeech tts;

    public AndroidHintSpeech(Context context)
    {
        tts = new TextToSpeech(context, new TextToSpeech.OnInitListener() {
            @Override
            public void onInit(int status) {
                if(status != TextToSpeech.ERROR) {
                    tts.setLanguage(Locale.UK);
                }
            }
        });

    }

    @Override
    public void setLanguage(String language) {
        if(language.equals("German")) {
           tts.setLanguage(Locale.GERMANY);
        }
        else if(language.equals("Spanish")) {
            tts.setLanguage(new Locale("es"));
        }
        else if(language.equals("English")){
            tts.setLanguage(Locale.UK);
        }
    }


    @Override
    public void Speech(String hint) {
        System.out.println("Que hablo!");

        tts.speak(hint, TextToSpeech.QUEUE_FLUSH, null);
    }


}
