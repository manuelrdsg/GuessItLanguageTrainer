package com.skel.game;

import com.badlogic.gdx.Gdx;
import com.badlogic.gdx.Input;
import com.badlogic.gdx.Screen;
import com.badlogic.gdx.graphics.GL20;
import com.badlogic.gdx.scenes.scene2d.InputEvent;
import com.badlogic.gdx.scenes.scene2d.Stage;
import com.badlogic.gdx.scenes.scene2d.ui.ImageTextButton;
import com.badlogic.gdx.scenes.scene2d.ui.Skin;
import com.badlogic.gdx.scenes.scene2d.ui.Table;
import com.badlogic.gdx.scenes.scene2d.ui.TextButton;
import com.badlogic.gdx.scenes.scene2d.utils.ClickListener;
import com.badlogic.gdx.utils.viewport.FillViewport;
import com.skel.util.Group;
import com.skel.util.HintSpeech;
import com.skel.util.Strings_I18N;
import com.skel.util.UserInfo;

/**
 * Created by juanmi on 30/08/2016.
 */
public class StatsMenuScreen implements Screen{

    private MainGame g;
    private UserInfo userInfo;
    private Group grupo;
    private Skin skin;

    private Stage stage;

    private Strings_I18N locale;

    private Table scroll_table;

    private TextButton StatButton, GoalButton;
    private HintSpeech toSpeech;

    public StatsMenuScreen(MainGame g, UserInfo UInfo, Group group, Skin skin, HintSpeech toSpeech){
        this.g = g;
        this.skin = skin;
        userInfo = UInfo;
        this.grupo = group;

        locale = new Strings_I18N(grupo.getLanguageName());

        create();
    }

    private void create(){
        stage = new Stage(new FillViewport(Gdx.graphics.getWidth(),Gdx.graphics.getHeight())){
            @Override
            public boolean keyDown(int keyCode) {
                if (keyCode == Input.Keys.BACK) {
                    g.setScreen(new MenuGameScreen(g, userInfo, grupo, skin, toSpeech));
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

    private void createStageActors(){

        scroll_table = new Table();

        StatButton = new TextButton("Stats", skin.get("default", TextButton.TextButtonStyle.class));

        StatButton.getLabel().setWrap(true);

        GoalButton = new TextButton("Achievements", skin.get("default", TextButton.TextButtonStyle.class));

        GoalButton.getLabel().setWrap(true);

        StatButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                g.setScreen(new StatsScreen(g, userInfo, grupo, skin, toSpeech));
                dispose();
            }
        });

        /*GoalButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                //g.setScreen(new StatsScreen(g, userInfo, grupo, skin));
                dispose();
            }
        });*/

        ImageTextButton backButton = new ImageTextButton(locale.back(), skin.get("back", ImageTextButton.ImageTextButtonStyle.class));
        backButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                g.setScreen(new MenuGameScreen(g, userInfo, grupo, skin, toSpeech));
                dispose();
            }
        });

        scroll_table.add(StatButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.2f);
        scroll_table.row();
        scroll_table.add(GoalButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.2f);
        scroll_table.row();
        scroll_table.add(backButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.2f);
        scroll_table.row();

        scroll_table.setFillParent(true);

        stage.addActor(scroll_table);
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
    }
}
