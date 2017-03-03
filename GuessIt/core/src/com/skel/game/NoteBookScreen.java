package com.skel.game;

import com.badlogic.gdx.*;
import com.badlogic.gdx.graphics.GL20;
import com.badlogic.gdx.scenes.scene2d.InputEvent;
import com.badlogic.gdx.scenes.scene2d.InputListener;
import com.badlogic.gdx.scenes.scene2d.Stage;
import com.badlogic.gdx.scenes.scene2d.ui.*;
import com.badlogic.gdx.scenes.scene2d.utils.ClickListener;
import com.badlogic.gdx.utils.Align;
import com.badlogic.gdx.utils.Array;
import com.badlogic.gdx.utils.viewport.FillViewport;
import com.badlogic.gdx.utils.viewport.StretchViewport;
import com.skel.util.HintSpeech;
import com.skel.util.Utils;

/**
 * Created by juanm on 08/03/2016.
 */
public class NoteBookScreen implements Screen {
    Utils utilidades = new Utils();
    private MainGame g;
    private Stage stage;
    private Skin skin;

    private Preferences defSaved;

    private Table scroller;
    private HintSpeech toSpeech;

    String[] keys;
    int i;

    public void createStageActors(){
        scroller = new Table();
        keys = defSaved.get().keySet().toArray(keys);
        for(i = 0; i < defSaved.get().size(); i++){
            final Label noteLabel = new Label(keys[i], skin.get("default", Label.LabelStyle.class));
            scroller.add(noteLabel).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.1f);
            scroller.row();
            final TextArea tmpTA = new TextArea(defSaved.getString(keys[i]), skin.get("default", TextField.TextFieldStyle.class));
            tmpTA.setMaxLength(80);
            tmpTA.setPrefRows(4);
            tmpTA.addListener(new InputListener(){
                public boolean keyTyped (InputEvent event, char character) {
                    super.keyTyped(event,character);
                    defSaved.putString(noteLabel.getText().toString(),tmpTA.getText());
                    defSaved.flush();
                    return true;
                }
            });
            scroller.add(tmpTA).width(Gdx.graphics.getWidth()*0.8f).height(Gdx.graphics.getHeight()*0.2f);
            scroller.row();
        }

        ImageTextButton CancelButton = new ImageTextButton("Back", skin.get("back", ImageTextButton.ImageTextButtonStyle.class));
        CancelButton.addListener(new ClickListener() {
            public void clicked(InputEvent event, float x, float y) {
                g.setScreen(new MainScreen(g, toSpeech));
                Gdx.input.setOnscreenKeyboardVisible(false);
                dispose();
            }
        });
        scroller.add(CancelButton).width(Gdx.graphics.getWidth() * 0.8f).height(Gdx.graphics.getHeight() * 0.1f);
        scroller.row();

        ScrollPane scrollerPane = new ScrollPane(scroller);
        Gdx.app.log("conexion", "scroll creado");

        final Table table = new Table();
        table.setFillParent(true);
        table.add(scrollerPane).fill().expand();

        stage.addActor(table);

    }

    public void create(){
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

    public NoteBookScreen(MainGame g, Skin skin, HintSpeech toSpeech){
        this.g = g;
        this.skin = skin;
        defSaved = Gdx.app.getPreferences("notebook");
        keys = new String[defSaved.get().size()];
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
