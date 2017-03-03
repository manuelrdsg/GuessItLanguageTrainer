package com.skel.game;

import com.badlogic.gdx.Gdx;
import com.badlogic.gdx.Input;
import com.badlogic.gdx.Screen;
import com.badlogic.gdx.graphics.GL20;
import com.badlogic.gdx.scenes.scene2d.InputEvent;
import com.badlogic.gdx.scenes.scene2d.Stage;
import com.badlogic.gdx.scenes.scene2d.ui.*;
import com.badlogic.gdx.scenes.scene2d.utils.ClickListener;
import com.badlogic.gdx.utils.Align;
import com.badlogic.gdx.utils.viewport.FillViewport;
import com.skel.util.HintSpeech;
import com.skel.util.Utils;

/**
 * Created by juanmi on 30/08/2016.
 */
public class CreditsScreen implements Screen{

    private Skin skin, skin2;
    private MainGame g;

    private Stage stage;

    private Table scroll_table;

    private HintSpeech toSpeech;

    public CreditsScreen(MainGame g, Skin skin, HintSpeech toSpeech){
        this.g = g;
        this.skin = skin;
        skin2 = new Utils().createResultSkin();
        this.toSpeech = toSpeech;
        create();
    }

    private void create(){
        stage = new Stage(new FillViewport(Gdx.graphics.getWidth(),Gdx.graphics.getHeight())){
            @Override
            public boolean keyDown(int keyCode) {
                if (keyCode == Input.Keys.BACK) {
                    g.setScreen(new MainScreen(g, toSpeech));
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

        Label directorLabel = new Label("[BLUE]Directora del proyecto:", skin2.get("result", Label.LabelStyle.class));
        Label director2Label = new Label("[OLIVE]Anke Berns", skin2.get("result", Label.LabelStyle.class));

        Label tutorLabel = new Label("[BLUE]Tutor del proyecto:", skin2.get("result", Label.LabelStyle.class));
        Label tutor2Label = new Label("[OLIVE]Manuel Palomo Duarte", skin2.get("result", Label.LabelStyle.class));

        Label developLabel = new Label("[BLUE]Desarrollador:", skin2.get("result", Label.LabelStyle.class));
        Label develop2Label = new Label("[OLIVE]Juan Miguel Ruiz Ladrón", skin2.get("result", Label.LabelStyle.class));
        Label develop3Label = new Label("[OLIVE]Manuel Rodríguez-Sánchez Guerra", skin2.get("result", Label.LabelStyle.class));

        Label colaboratorsLabel = new Label("[BLUE]Colaboradores:", skin2.get("result", Label.LabelStyle.class));
        Label colaborators2Label = new Label("[OLIVE]Alicia Garrido Guerrero", skin2.get("result", Label.LabelStyle.class));
        Label colaborators3Label = new Label("[OLIVE]Mercedes Paéz Piña", skin2.get("result", Label.LabelStyle.class));
        Label colaborators4Label = new Label("[OLIVE]Salvador Reyes Sánchez", skin2.get("result", Label.LabelStyle.class));
        Label colaborators5Label = new Label("[OLIVE]Lorena Gutiérrez Madroñal", skin2.get("result", Label.LabelStyle.class));

        Label logo = new Label("", skin.get("logo", Label.LabelStyle.class));

        directorLabel.setWrap(true);
        director2Label.setWrap(true);

        tutorLabel.setWrap(true);
        tutor2Label.setWrap(true);

        developLabel.setWrap(true);
        develop2Label.setWrap(true);
        develop3Label.setWrap(true);

        colaboratorsLabel.setWrap(true);
        colaborators2Label.setWrap(true);
        colaborators3Label.setWrap(true);
        colaborators4Label.setWrap(true);
        colaborators5Label.setWrap(true);

        directorLabel.setAlignment(Align.left);
        director2Label.setAlignment(Align.left);

        tutorLabel.setAlignment(Align.left);
        tutor2Label.setAlignment(Align.left);

        developLabel.setAlignment(Align.left);
        develop2Label.setAlignment(Align.left);
        develop3Label.setAlignment(Align.left);

        colaboratorsLabel.setAlignment(Align.left);
        colaborators2Label.setAlignment(Align.left);
        colaborators3Label.setAlignment(Align.left);
        colaborators4Label.setAlignment(Align.left);
        colaborators5Label.setAlignment(Align.left);

        ImageTextButton backButton = new ImageTextButton("Back", skin.get("back", ImageTextButton.ImageTextButtonStyle.class));
        backButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                g.setScreen(new MainScreen(g, toSpeech));
                dispose();
            }
        });

        scroll_table.add(logo).width(Gdx.graphics.getWidth()*0.3f).height(Gdx.graphics.getHeight()*0.2f).colspan(2);
        scroll_table.row();

        scroll_table.add(tutorLabel).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f).colspan(2);
        scroll_table.row();

        scroll_table.add().width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.add(tutor2Label).width(Gdx.graphics.getWidth()*0.7f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.row();

        scroll_table.add(directorLabel).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f).colspan(2);
        scroll_table.row();

        scroll_table.add().width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.add(director2Label).width(Gdx.graphics.getWidth()*0.7f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.row();

        scroll_table.add(developLabel).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f).colspan(2);
        scroll_table.row();

        scroll_table.add().width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.add(develop2Label).width(Gdx.graphics.getWidth()*0.7f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.row();

        scroll_table.add().width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.add(develop3Label).width(Gdx.graphics.getWidth()*0.7f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.row();

        scroll_table.add(colaboratorsLabel).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f).colspan(2);
        scroll_table.row();

        scroll_table.add().width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.add(colaborators2Label).width(Gdx.graphics.getWidth()*0.7f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.row();

        scroll_table.add().width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.add(colaborators3Label).width(Gdx.graphics.getWidth()*0.7f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.row();

        scroll_table.add().width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.add(colaborators4Label).width(Gdx.graphics.getWidth()*0.7f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.row();

        scroll_table.add().width(Gdx.graphics.getWidth()*0.1f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.add(colaborators5Label).width(Gdx.graphics.getWidth()*0.7f).height(Gdx.graphics.getHeight()*0.1f);
        scroll_table.row();


        scroll_table.add(backButton).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f).colspan(2);
        scroll_table.row();

        ScrollPane scroller = new ScrollPane(scroll_table);
        final Table table = new Table();
        table.setFillParent(true);

        table.add(scroller).expand().fill();

        stage.addActor(table);

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
