package com.skel.game;

import com.badlogic.gdx.Game;
import com.badlogic.gdx.Gdx;
import com.badlogic.gdx.Input;
import com.badlogic.gdx.Screen;
import com.badlogic.gdx.graphics.GL20;
import com.badlogic.gdx.scenes.scene2d.InputEvent;
import com.badlogic.gdx.scenes.scene2d.InputListener;
import com.badlogic.gdx.scenes.scene2d.Stage;
import com.badlogic.gdx.scenes.scene2d.ui.ImageTextButton;
import com.badlogic.gdx.scenes.scene2d.ui.Skin;
import com.badlogic.gdx.scenes.scene2d.ui.Table;
import com.badlogic.gdx.scenes.scene2d.ui.TextButton;
import com.badlogic.gdx.scenes.scene2d.utils.ClickListener;
import com.badlogic.gdx.utils.viewport.FillViewport;
import com.badlogic.gdx.utils.viewport.StretchViewport;
import com.skel.util.*;

/**
 * Created by juanm on 25/02/2016.
 */
public class MenuGameScreen implements Screen {

    Utils utilidades = new Utils();

    private Stage stage;
    private Skin skin;
    private Strings_I18N locale;
    MainGame g;
    UserInfo userInfo;
    Group grupo;
    private HintSpeech toSpeech;

    public void createStageActors(){
        TextButton playButton = new TextButton(locale.play(), skin.get("default", TextButton.TextButtonStyle.class));
        TextButton statsButton = new TextButton(locale.stats(), skin.get("default", TextButton.TextButtonStyle.class));
        ImageTextButton backButton = new ImageTextButton(locale.back(), skin.get("back", ImageTextButton.ImageTextButtonStyle.class));
        TextButton newDefButton = new TextButton(locale.addDef(), skin.get("default", TextButton.TextButtonStyle.class));

        playButton.getLabel().setWrap(true);
        statsButton.getLabel().setWrap(true);
        backButton.getLabel().setWrap(true);
        newDefButton.getLabel().setWrap(true);

        if(userInfo.canAddDefinition(String.valueOf(grupo.getId()))){
            newDefButton.setVisible(true);
        }else{
            newDefButton.setVisible(false);
        }

        playButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                g.setScreen(new ConfigGameScreen(g,userInfo, grupo, skin, toSpeech));
                dispose();
            }
        });

        statsButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                g.setScreen(new StatsMenuScreen(g, userInfo, grupo, skin, toSpeech));
                dispose();
            }
        });

        newDefButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                g.setScreen(new NewDefScreen(g, userInfo, grupo, skin, toSpeech));
                dispose();
            }
        });

        backButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                g.setScreen(new UserGroupsScreen(g, userInfo, skin, toSpeech));
                dispose();
            }
        });

        Table layout = new Table();

        layout.add(playButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.2f);
        layout.row();
        layout.add(statsButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.2f);
        layout.row();
        layout.add(newDefButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.2f);
        layout.row();
        layout.add().width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f);
        layout.row();
        layout.add(backButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.2f);
        layout.row();

        layout.setFillParent(true);

        stage.addActor(layout);
    }

    public void create(){
        stage = new Stage(new FillViewport(Gdx.graphics.getWidth(),Gdx.graphics.getHeight())){
            @Override
            public boolean keyDown(int keyCode) {
                if (keyCode == Input.Keys.BACK) {
                    g.setScreen(new UserGroupsScreen(g, userInfo, skin, toSpeech));
                    Gdx.input.setOnscreenKeyboardVisible(false);
                    dispose();
                }
                return super.keyDown(keyCode);
            }
        };
        Gdx.input.setInputProcessor(stage);
        Gdx.input.setCatchBackKey(true);

        createStageActors();
    }

    public MenuGameScreen(MainGame g, UserInfo UInfo, Group grupo, Skin skin, HintSpeech toSpeech){
        this.g = g;
        this.skin = skin;
        userInfo = UInfo;
        this.grupo = grupo;
        locale = new Strings_I18N(grupo.getLanguageName());
        this.toSpeech = toSpeech;
        create();
    }
    @Override
    public void show() {

    }

    @Override
    public void render(float delta) {
        Gdx.gl.glClear(GL20.GL_COLOR_BUFFER_BIT);
        Gdx.gl.glClearColor(0.95f, 0.95f, 0.95f, 1);
        stage.act(delta);
        stage.draw();
    }

    @Override
    public void resize(int width, int height) {

    }

    @Override
    public void pause() {

    }

    @Override
    public void resume() {

    }

    @Override
    public void hide() {

    }

    @Override
    public void dispose() {
        stage.dispose();
        //skin.dispose();
    }
}
