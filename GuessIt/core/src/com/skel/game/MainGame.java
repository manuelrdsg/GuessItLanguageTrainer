package com.skel.game;

import com.badlogic.gdx.Game;
import sun.applet.Main;
import com.skel.util.HintSpeech;

import javax.swing.*;

/**
 * Created by juanm on 27/01/2016.
 */
public class MainGame extends Game {

    private HintSpeech toSpeech;

    public MainGame(HintSpeech toSpeech){
        this.toSpeech = toSpeech;
    }

    public void create(){
        setScreen(new MainScreen(this, toSpeech));
    }

    @Override
    public void dispose() {
        super.dispose();
    }

    @Override
    public void render() {
        super.render();
    }

    @Override
    public void resize(int width, int height) {
        super.resize(width, height);
    }

    @Override
    public void pause() {
        super.pause();
    }

    @Override
    public void resume() {
        super.resume();
    }
}
